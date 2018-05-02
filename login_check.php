<?php
	session_start();
	require_once ('MysqliDb.php');
	$_SESSION['uID'] = "";
	$uid = addslashes($_POST['uid']);
	$pwd = addslashes($_POST['pwd']);
	$table= addslashes($_POST['options']);
	$d=date("Y-m-d");
	////////////
	$db = new MysqliDb();
	if($table=="member"){
		$sql_str = "SELECT m.user_ID,m.name FROM member as m WHERE m.user_ID= '".$uid."' and m.passwords='".$pwd."' and m.enable='1' and m.disable_deadline<='".$d."'";
		$user = $db->rawQuery($sql_str);
		if($user[0]["user_ID"]==""){//登入失敗		
			$send="Invalid Username or Password or account disable";
			header("Location: index.php?send=$send");
		}
	   else{
			$_SESSION['uID'] = $user[0]['user_ID'];
			$_SESSION['name'] =$user[0]['name'];
			header("Location: Show_all_petition.php");
	   }
	}
	else if($table=="government"){//政府
		$sql_str = "SELECT gov_ID,name,department FROM government WHERE gov_ID= '".$uid."' and passwords='".$pwd."' and enable='1' ";
		$user = $db->rawQuery($sql_str);
		if($user[0]["gov_ID"]==""){//登入失敗		
			$send="Invalid Username or Password account disable";
			header("Location: index.php?send=$send");		
		}
		else{
			$_SESSION['gID']=$user[0]['gov_ID'];
			$_SESSION['dep']=$user[0]['department'];
			$_SESSION['name']=$user[0]['name'];
			header("Location: Show_keyword_statistic.php");
		}
	}
	else{//登入成功
		$sql_str = "SELECT name,man_ID FROM manager WHERE man_ID= '".$uid."'and passwords='".$pwd."'";
		$user = $db->rawQuery($sql_str);
		if($user[0]['man_ID']==""){
			$send="Invalid Username or Password";
			header("Location: index.php?send=$send");	
		}
		else{
			$_SESSION['mID']=$user[0]['man_ID'];
			$_SESSION['name']=$user[0]['name'];
			header("Location: Account_management.php");
		}
	}
?>
