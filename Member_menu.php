<html>
<head>
    <link rel="stylesheet" href="member_menu_css.css">
</head>
<body style="margin: 0px; background-color: #d8e7f3; font-family='微軟正黑體', 'Arial';">


<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017/12/18
 * Time: 下午 03:26
 */

$name = "";
$user_id = "";
session_start();

if (isset($_GET["mode"])){
    if ($_GET["mode"]=="test"){
        $name = $_GET["name"];
        $user_id = $_GET["user_id"];
    }
}
else{
    if (!isset($_SESSION["uID"]) OR $_SESSION["uID"]==""){
        header("Location: index.php");
    }
    else{
        $name = $_SESSION['name'];
        $user_id = $_SESSION['uID'];
    }
}

echo "<div class='m'>";
echo "<table class='c'>";
echo "<td class='btner'><a href='Search_accident_road.php'>查詢事故路段</a></td>";
echo "<td class='btner'><a href='Search_crime_road.php'>查詢竊盜路段</a></td>";
echo "<td class='btner'><a href='Search_record.php'>查詢搜尋記錄</a></td>";
echo "<td class='btner'><a href='Petition.php'>新增陳情文章</a></td>";
echo "<td class='btner'><a href='Search_petition.php'>查詢個人陳情記錄</a></td>";
echo "<td class='btner'><a href='Show_all_petition.php'>列出市民陳情</a></td>";
echo "<td style='width: 20px'>||</td>";
echo "<td style='width: 180px'>你好，<a href='Member_edit.php' id='usename' class='btner'>".$name."</a></td>";
echo "<td class='btner' style='width: 50px'><a href='logout.php'>登出</a></td>";
echo "</table>";
echo "</div>";

?>
</body>
