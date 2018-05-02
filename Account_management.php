<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>政府人員帳戶管理</title>
<link rel="stylesheet" href="mag_css.css">
<link rel="stylesheet" href="manager_css.css">
</head>	
	<script type="text/javascript">
    function writePassword(user_type, user_id, name){
        document.getElementById("update_div").style.display = "inline";
        document.getElementById("user_ID").value = user_id;
        document.getElementById("name").value = name;
		document.getElementById("user_type").value = user_type;
    }
    function NonDisplay() {
        document.getElementById("update_div").style.display = "none";
    }
	function password_alert_fail(){alert("密碼不一致");}
	function password_alert_success(){alert("密碼修改成功");}
</script>
	
<body>
<?php include ("Manager_menu.php"); ?>
<h1 class="h1">帳戶管理</h1>
<div id="update_div" style="display: none; width: 100%; height: 100%; position: fixed; text-align: center position:absolute; top:0; left:0; z-index:50 ;">
	<div style="background-color: rgba(255,255,255,0.8); padding-top: 10%; width: 100%; height: 100%; text-align: center;">
        <div style="width:45%; margin: 0 auto; background-color: #cc99ff; padding: 30px; border: 5px solid white;">
            <form method="post" style="margin-bottom: 0px;">
                <p style="text-align: left; font-weight: bold; color: black; font-size: 16px; margin: 0px">使用者帳號：
				<input style="background-color: #cc99ff; border: 0px;" type='text' readonly='readonly' id='user_ID' name='user_ID' value=''></p><br/>
				<p style="text-align: left; font-weight: bold; color: black; font-size: 16px; margin: 0px">使用者名稱：
				<input style="background-color: #cc99ff; border: 0px;" type='text' readonly='readonly' id='name' name='name' value=''></p>
				<input type='hidden' id='user_type' name='user_type' value=''>
				<br/><hr/ style='border-color: #d9b3ff'>
                <label>輸入密碼：<input type="password" name='Password'></label><br/><br/>
				<label>確認密碼：<input type="password" name='password'></label><br/><br/>
                <input type='submit'  style='font-family: "Tahoma", "微軟正黑體";' name='update_password' value='確認' />&nbsp;&nbsp;&nbsp;
				<input type="submit" onclick='NonDisplay()' value="取消">
            </form>
        </div>
    </div>
</div>
	

<p>
<form method="post" style="padding-left: 40%">
	  <label for="">查詢帳號：</label>
	  <input name="userid" type="text" id="userid">	  		
	  <br><br>
	  <label for="">查詢名稱：</label>
	  <input type="text" name="username" id="username">
	  <br><br>
	  <label>
	    使用者類型：</label>
	    <label>
	      <input type="checkbox" name="usertype_n" value=" 一般民眾" id="usertype_0">
	      一般民眾</label>
	    <label>
	      <input type="checkbox" name="usertype_g" value="政府人員" id="usertype_1">
	      政府人員</label>
	    <br><br>
	  <label>停權紀錄：　</label>
	    <label>
	      <input type="checkbox" name="report_y" value=" 有" id="report_0">
	      有　　　</label>
	    <label>
	      <input type="checkbox" name="report_n" value="無" id="report_1">
	      無</label>
	    <br><br>
	<input type="submit" value="送出">&nbsp;&nbsp;&nbsp;<input type="reset" value="取消">
</form>
<hr>
<table class="table" align="center" width='70%' border='1' align='left'>
  	 <tbody><tr>
     <th class="th" width='250' align='center'>使用者類型</th>
     <th class="th" width='250' align='center'>帳號</th>
     <th class="th" width='250' align='center'>名稱</th>
     <th class="th" width='250' align='center'>停權次數</th>
     <th class="th" width='250' align='center'>停權期限</th>
     <th class="th" width='250' align='center'>更新</th>
     <th class="th" width='250' align='center'>刪除</th>
     </tr>
<?php

include("Manager_function.php");
$manager = new manager_function();
//----------------------------table----------------------------------
if((array_key_exists("delete_gov_user_type",$_POST))&&(array_key_exists("delete_gov_user_id",$_POST))){
	$delete_gov=$_POST['delete_gov_user_type'];
	$delete_govid=$_POST['delete_gov_user_id'];
	$delete=[$delete_gov,$delete_govid];
	//echo($delete[0].$delete[1]);
	$delete_result=$manager->DeleteAccount($delete);
	echo($delete_result);
}
if((array_key_exists("delete_normal_user_type",$_POST))&&(array_key_exists("delete_normal_user_id",$_POST))){
	$delete_normal=$_POST['delete_normal_user_type'];
	$delete_userid=$_POST['delete_normal_user_id'];
	$delete=[$delete_normal,$delete_userid];
	//echo($delete[0].$delete[1]);
	$delete_result=$manager->DeleteAccount($delete);
	echo($delete_result);
}
//----------------------------delete----------------------------------
error_reporting(E_ALL || ~E_NOTICE);
$update_usertype=$_POST['user_type'];
$update_userid=$_POST['user_ID'];
$update_password=$_POST['Password'];
$update_repassword=$_POST['password'];
if($update_password==$update_repassword&&empty($update_password)!=1){
$update=[$update_usertype,$update_userid,$update_password];
$update_result=$manager->UpdateAccount($update);
echo  "<script type='text/javascript'>password_alert_success()</script>";
}elseif(empty($update_password)!=1) echo "<script type='text/javascript'>password_alert_fail()</script>";
//----------------------------update----------------------------------
error_reporting(E_ALL || ~E_NOTICE);	 
$userid=$_POST['userid'];
$username=$_POST['username'];
$usertype_n=$_POST['usertype_n'];
$usertype_g=$_POST['usertype_g'];
$report_y=$_POST['report_y'];
$report_n=$_POST['report_n'];
$search=[$userid,$username,$usertype_n,$usertype_g,$report_y,$report_n];
//----------------------------parameter----------------------------------
	$usertype_n="一般民眾";
	$usertype_g="政府人員";
	if((empty($search[2])!=1&&empty($search[3])!=1)||(empty($search[2])==1&&empty($search[3])==1)){
		$result_n = $manager->SearchAccount_normal($search);
		$result_g = $manager->SearchAccount_government($search);
		foreach($result_n as $row){
                if($row["report_num"]>=1){
					echo("<tr class='tr'><td class='td' width='250' align='center'>一般民眾</td>
					<td class='td' width='250' align='center'>".$row["user_ID"]."</td>
					<td class='td' width='250' align='center'>".$row["name"]."</td>
					<td class='td' width='250' align='center'>".$row["report_num"]."</td>
					<td class='td' width='250' align='center'>".$row["disable_deadline"]."</td>					
					<td class='td' width='250' align='center'>
					<input onclick=\"writePassword('".$usertype_n."','".$row["user_ID"]."', '".$row["name"]."')\" type='submit' style='font-family: 'Tahoma', '微軟正黑體';' name='report' value='更新' /></td>");

                    if($row["enable"]==0){echo ("<td class='td' width='250' align='center'>".已刪除."</td>");
                    }else{ echo ("<td class='td' width='250' align='center'>
					<form method='post'>
					<input type='submit' value='刪除'>
					<input type='hidden' name='delete_normal_user_type' value='".$usertype_n."'>
					<input type='hidden' name='delete_normal_user_id' value='".$row["user_ID"]."'></form></td></tr>");}
				}elseif($row["report_num"]>=1&&empty($row["disable_deadline"])==1){
					echo("<tr class='tr'><td class='td' width='250' align='center'>一般民眾</td>
					<td class='td' width='250' align='center'>".$row["user_ID"]."</td>
					<td class='td' width='250' align='center'>".$row["name"]."</td>
					<td class='td' width='250' align='center'>".$row["report_num"]."</td>
					<td class='td' width='250' align='center'>-</td>
					
					<td class='td' width='250' align='center'>
					<input onclick=\"writePassword('".$usertype_n."','".$row["user_ID"]."', '".$row["name"]."')\" type='submit' style='font-family: 'Tahoma', '微軟正黑體';' name='report' value='更新' /></td>");
					
					if($row["enable"]==0){echo ("<td class='td' width='250' align='center'>".已刪除."</td>");
                    }else{ echo ("<td class='td' width='250' align='center'>
					<form method='post'>
					<input type='submit' value='刪除'>
					<input type='hidden' name='delete_normal_user_type' value='".$usertype_n."'>
					<input type='hidden' name='delete_normal_user_id' value='".$row["user_ID"]."'>
					</form></td></tr>");}
				}else{
					echo("<tr class='tr'><td class='td' width='250' align='center'>一般民眾</td>
					<td class='td' width='250' align='center'>".$row["user_ID"]."</td>
					<td class='td' width='250' align='center'>".$row["name"]."</td>
					<td class='td' width='250' align='center'>-</td>
					<td class='td' width='250' align='center'>-</td>
					
					<td class='td' width='250' align='center'>
					<input onclick=\"writePassword('".$usertype_n."','".$row["user_ID"]."', '".$row["name"]."')\" type='submit' style='font-family: 'Tahoma', '微軟正黑體';' name='report' value='更新' /></td>");
					
					if($row["enable"]==0){echo ("<td class='td' width='250' align='center'>".已刪除."</td>");
                    }else{ echo ("<td class='td' width='250' align='center'>
					<form method='post'>
					<input type='submit' value='刪除'>
					<input type='hidden' name='delete_normal_user_type' value='".$usertype_n."'>
					<input type='hidden' name='delete_normal_user_id' value='".$row["user_ID"]."'>
					</form></td></tr>");}
				}
		}
		if(empty($search[4])==1){
		foreach($result_g as $row){
			echo("<tr class='tr'><td class='td' width='250' align='center'>政府人員</td>
			<td class='td' width='250' align='center'>".$row["gov_ID"]."</td>
			<td class='td' width='250' align='center'>".$row["name"]."</td>
			<td class='td' width='250' align='center'>-</td>
			<td class='td' width='250' align='center'>-</td>

			<td class='td' width='250' align='center'>
			<input onclick=\"writePassword('".$usertype_g."','".$row["gov_ID"]."', '".$row["name"]."')\" type='submit' style='font-family: 'Tahoma', '微軟正黑體';' name='report' value='更新' /></td>");

			if($row["enable"]==0){echo ("<td class='td' width='250' align='center'>".已刪除."</td>");
			}else{ echo ("<td class='td' width='250' align='center'>
			<form method='post'>
			<input type='submit' value='刪除'>
			<input type='hidden' name='delete_gov_user_type' value='".$usertype_g."'>
			<input type='hidden' name='delete_gov_user_id' value='".$row["gov_ID"]."'>
			</form></td></tr>");}
		}}
	}elseif(empty($search[2])!=1){
		$result_n = $manager->SearchAccount_normal($search);
		foreach($result_n as $row){
				if($row["report_num"]>=1){
					echo("<tr class='tr'><td class='td' width='250' align='center'>一般民眾</td>
					<td class='td' width='250' align='center'>".$row["user_ID"]."</td>
					<td class='td' width='250' align='center'>".$row["name"]."</td>
					<td class='td' width='250' align='center'>".$row["report_num"]."</td>
					<td class='td' width='250' align='center'>".$row["disable_deadline"]."</td>
					
					<td class='td' width='250' align='center'>
					<input onclick=\"writePassword('".$usertype_n."','".$row["user_ID"]."', '".$row["name"]."')\" type='submit' style='font-family: 'Tahoma', '微軟正黑體';' name='report' value='更新' /></td>");
					
					if($row["enable"]==0){echo ("<td class='td' width='250' align='center'>".已刪除."</td>");
                    }else{ echo ("<td class='td' width='250' align='center'>
					<form method='post'>
					<input type='submit' value='刪除'>
					<input type='hidden' name='delete_normal_user_type' value='".$usertype_n."'>
					<input type='hidden' name='delete_normal_user_id' value='".$row["user_ID"]."'>
					</form></td></tr>");}
				}elseif($row["report_num"]>=1&&empty($row["disable_deadline"])==1){
					echo("<tr class='tr'><td class='td' width='250' align='center'>一般民眾</td>
					<td class='td' width='250' align='center'>".$row["user_ID"]."</td>
					<td class='td' width='250' align='center'>".$row["name"]."</td>
					<td class='td' width='250' align='center'>".$row["report_num"]."</td>
					<td class='td' width='250' align='center'>-</td>
					
					<td class='td' width='250' align='center'>
					<input onclick=\"writePassword('".$usertype_n."','".$row["user_ID"]."', '".$row["name"]."')\" type='submit' style='font-family: 'Tahoma', '微軟正黑體';' name='report' value='更新' /></td>");
					
					if($row["enable"]==0){echo ("<td class='td' width='250' align='center'>".已刪除."</td>");
                    }else{ echo ("<td class='td' width='250' align='center'>
					<form method='post'>
					<input type='submit' value='刪除'>
					<input type='hidden' name='delete_normal_user_type' value='".$usertype_n."'>
					<input type='hidden' name='delete_normal_user_id' value='".$row["user_ID"]."'>
					</form></td></tr>");}
				}else{
					echo("<tr class='tr'><td class='td' width='250' align='center'>一般民眾</td>
					<td class='td' width='250' align='center'>".$row["user_ID"]."</td>
					<td class='td' width='250' align='center'>".$row["name"]."</td>
					<td class='td' width='250' align='center'>-</td>
					<td class='td' width='250' align='center'>-</td>
					
					<td class='td' width='250' align='center'>
					<input onclick=\"writePassword('".$usertype_n."','".$row["user_ID"]."', '".$row["name"]."')\" type='submit' style='font-family: 'Tahoma', '微軟正黑體';' name='report' value='更新' /></td>");
					
					if($row["enable"]==0){echo ("<td class='td' width='250' align='center'>".已刪除."</td>");
                    }else{ echo ("<td class='td' width='250' align='center'>
					<form method='post'>
					<input type='submit' value='刪除'>
					<input type='hidden' name='delete_normal_user_type' value='".$usertype_n."'>
					<input type='hidden' name='delete_normal_user_id' value='".$row["user_ID"]."'>
					</form></td></tr>");}
				}			
		}
	}
	elseif(empty($search[3])!=1 && empty($search[4])==1){
		$result_g = $manager->SearchAccount_government($search);
		foreach($result_g as $row){
			echo("<tr class='tr'><td class='td' width='250' align='center'>政府人員</td>
			<td class='td' width='250' align='center'>".$row["gov_ID"]."</td>
			<td class='td' width='250' align='center'>".$row["name"]."</td>
			<td class='td' width='250' align='center'>-</td>
			<td class='td' width='250' align='center'>-</td>

			<td class='td' width='250' align='center'>
			<input onclick=\"writePassword('".$usertype_g."','".$row["gov_ID"]."', '".$row["name"]."')\" type='submit' style='font-family: 'Tahoma', '微軟正黑體';' name='report' value='更新' /></td>");

            if($row["enable"]==0){echo ("<td class='td' width='250' align='center'>".已刪除."</td>");
            }else{ echo ("<td class='td' width='250' align='center'>
			<form method='post'>
			<input type='submit' value='刪除'>
			<input type='hidden' name='delete_gov_user_type' value='".$usertype_g."'>
			<input type='hidden' name='delete_gov_user_id' value='".$row["gov_ID"]."'>
			</form></td></tr>");}
		}
	}
?>
</table><br><br>

</body>
</html>