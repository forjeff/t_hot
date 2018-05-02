<html>
<head>
    <title>審查被檢舉文章</title>
    <link rel="stylesheet" href="manager_css.css">
</head>
<body style="margin: 0px; font-family: 'Arial', '微軟正黑體'; background-color: #ccffcc">

<?php
include("Manager_menu.php");
include("Manager_function.php");
$manager = new manager_function();
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017/12/12
 * Time: 下午 07:45
 */



if(array_key_exists('disable', $_POST)){
//    echo $_POST["pet_ID"];
    $manager->VerifyReportedPetition($_POST["pet_ID"], 1);
}
if(array_key_exists('available', $_POST)){
    $manager->VerifyReportedPetition($_POST["pet_ID"], 0);
}

//show table
$results = $manager->ShowReportedPetition();
echo "<h1 class='h1'> 審查被檢舉文章 </h1>";
echo "<table class='table'>";
echo "<tr><th class='th'>時間</th><th class='th'>使用者 ID</th><th class='th' width='250px'>文章內容</th>";
echo "<th class='th'>政府人員 ID</th><th class='th'>檢舉事由</th><th class='th' width='120px'>處理狀態</th></tr>";

foreach($results as $row){
    echo "<tr class='tr'>";
    echo "<td class='td'>".$row["time"]."</td><td class='td'>".$row["user_ID"]."</td><td class='td1'>".$row["content"]."</td>";
    echo "<td class='td'>".$row["gov_ID"]."</td><td class='td1'>".$row["comment"]."</td>";
    if($row["status"]=="未處理"){
        echo "<td class='td' style='padding: auto;'>";
        echo "<form method='post' style='margin: 0px'>";
        echo "<input type='submit' style='font-family: \"Arial\", \"微軟正黑體\";' name='disable' value='停權' />"." ";
        echo "<input type='submit' style='font-family: \"Arial\", \"微軟正黑體\";' name='available' value='不停權' />";
        echo "<input type='hidden' name='pet_ID' value = '".$row['petition_ID'] ."'/>";
        echo "</form>";
        echo "</td>";
    }
    else{
        echo "<td class='td'>".$row["status"]."</td>";
    }
    echo "</tr>";
}

echo "</table>";
echo "<br/><br/>";
?>
</body>
</html>
