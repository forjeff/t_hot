<html>
<head>
    <link rel="stylesheet" href="manager_menu_css.css">
</head>
<body style="margin: 0px; font-family: 'Arial', '微軟正黑體'; background-color: #ccffcc">


<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017/12/18
 * Time: 下午 04:22
 */

$name = "";
$mag_id = "";
session_start();

if (isset($_GET["mode"])){
    if ($_GET["mode"]=="test"){
        $name = $_GET["name"];
        $mag_id = $_GET["mag_id"];
    }
}
else{
    if (!isset($_SESSION["mID"]) OR $_SESSION["mID"]==""){
        header("Location: index.php");
    }
    else{
        $name = $_SESSION['name'];
        $mag_id = $_SESSION['mID'];
    }
}

echo "<div class='menu'>";
echo "<table>";
echo "<td class='btn'><a href='Account_management.php'>帳戶管理</a></td>";
echo "<td class='btn'><a href='New_government.php'>新增政府人員</a></td>";
echo "<td class='btn'><a href='Reported_petition.php'>審查被檢舉文章</a></td>";
echo "<td style='width: 30%'></td>";
echo "<td style='width: 20px'>||</td>";
echo "<td style='width: 180px'>你好，".$name."</td>";
echo "<td class='btn' style='width: 50px'><a href='logout.php' class='a'>登出</a></td>";
echo "</table>";
echo "</div>";
?>
</body>
