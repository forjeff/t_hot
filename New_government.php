<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>新增政府人員</title>
<link rel="stylesheet" href="manager_css.css">
</head>
<?php
include ("Manager_menu.php");
include ("Manager_function.php");
require_once ('MysqliDb.php');
$manager = new manager_function();
?>
<h1 class="h1">新增政府人員</h1>
<p>
<form method="post" style="padding-left: 40%">
	  <label for="">使用者帳號：</label>
	  <input name="userid" type="text" id="userid" required>	  		
	  <br><br>
	  <label for="">使用者名稱：</label>
	  <input name="username" type="text" id="username" required>
	  <br><br>
	  <label for="">輸入密碼　：</label>
	  <input name="password" type="password" id="password" required>
	  <br><br>
	  <label for="">所屬部門　：</label>
      <select name='department' class='opts'>
      <?php
      $db = new MysqliDb ();
      $sql = "SELECT * FROM petition_type_department";
      $result = $db->rawQuery($sql);
      foreach($result as $row){
          echo( "<option value='".$row["petition_type"]."'>".$row["petition_type"]."</option>");}
      ?>
      </select>
	  <br><br>
	  <label for="">電子信箱　：</label>
	  <input name="email" type="text" id="email" required>
	  <br><br>
	<input type="submit" value="送出">&nbsp;&nbsp;&nbsp;<input type="reset" value="取消">
	<br><br>
</form></p>
<div class=out1 style='text-align:center'>
<?php
	error_reporting(E_ALL || ~E_NOTICE);
	require_once ('MysqliDb.php');
	$db = new MysqliDb ();
	$gov_id = $_POST['userid'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	$department = $_POST['department'];
	$email = $_POST['email'];
	$manager->NewGovernment($gov_id, $username,$department, $password, $email);
?>
</div>
<body>
</body>
</html>