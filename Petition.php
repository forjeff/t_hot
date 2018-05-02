<?php
include('Member_function.php');
$member = new Member_function();
include('Member_menu.php');
?>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>我要陳情</title>

		<link rel="stylesheet" type="text/css" href="petition.css">
    </head>
    <body style="margin: 0px; background-color: #d8e7f3">
		<form action="" method="post">
			<h1 align="center">我要陳情</h1>
			<fieldset>
				<center>陳情類別：
				<select name="type" size="1" align="center">
					<option value="交通">交通</option>
					<option value="治安">治安</option>
					<option value="工務">工務</option>
				<select></center>
				<br>
				<h3 align="center">陳情內容描述：<h3>
				<center><textarea rows="6" cols="100" name="PetitionComment" align="center" valign="center"></textarea></center><br>
				<center><input type="submit"/>
				<input type="reset"></center><br>
			</fieldset>
		</form>
    </body>
</html>
<?php

if($_POST){
	//測試
    /*if (empty($user_id)){
        $user_id="test";
    }*/
	$type =$_POST["type"];
	$content =$_POST["PetitionComment"];
	if(empty($content)){
		echo "<script>alert('輸入失敗，請重新輸入');</script>";
	}else{
		$member -> NewPetition($user_id,$type,$content);
		echo "<script>alert('輸入成功');</script>";
	}
}
?>