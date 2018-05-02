<html>
<head>
    <link rel="stylesheet" href="government_menu_css.css">
</head>
<body style="margin: 0px; font-family: 'Arial', '微軟正黑體'; background-color: #fae6ff">


<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017/12/18
 * Time: 下午 04:09
 */

$name = "";
$gov_id = "";
$dep = "";
session_start();

if (isset($_GET["mode"])){
    if ($_GET["mode"]=="test"){
        $name = $_GET["name"];
        $gov_id = $_GET["gov_id"];
        $dep = $_GET["dep"];
    }
}
else{
    if (!isset($_SESSION["gID"]) OR $_SESSION["gID"]==""){
        header("Location: index.php");
    }
    else{
        $name = $_SESSION['name'];
        $gov_id = $_SESSION['gID'];
        $dep = $_SESSION['dep'];
    }
}

echo "<div class='menu'>";
echo "<table>";
echo "<td class='btn'><a href='Show_keyword_statistic.php'>查看關鍵字統計</a></td>";
echo "<td class='btn'><a href='Show_petition_record.php'>查看陳情記錄</a></td>";
echo "<td class='btn'><a href='Show_petition_completion_rate.php'>陳情完成率統計</a></td>";
echo "<td style='width: 25%'></td>";
echo "<td style='width: 20px'>||</td>";
echo "<td style='width: 180px'>你好，".$name."</td>";
echo "<td class='btn' style='width: 50px'><a href='logout.php'>登出</a></td>";
echo "</table>";
echo "</div>";
?>
</body>
