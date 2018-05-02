<html>
<head>
    <title>使用者陳情文章</title>
    <link rel="stylesheet" href="gov_css.css">
</head>
<script type="text/javascript">
    function writeComment(gov_id, petition_id){
        //顯示檢舉事由頁面
        document.getElementById("comment_div").style.display = "inline";
        // 先將form裡所hidden的那兩個input的value值更改
        document.getElementById("pet_ID").value = petition_id;
        document.getElementById("gov_ID").value = gov_id;
    }
    function NonDisplay() {
        document.getElementById("comment_div").style.display = "none";
    }
</script>
<body style="margin: 0px; font-family: 'Arial', '微軟正黑體'; background-color: #fae6ff">
<div id="comment_div" style="display: none; width: 100%; height: 100%; position: fixed; text-align: center;">
    <div style="background-color: rgba(255,255,255,0.8); padding-top: 10%; width: 100%; height: 100%; text-align: center;">
        <div style="width:45%; margin: 0 auto; background-color: #cc99ff; padding: 30px; border: 5px solid white;">
            <form method="post" style="margin-bottom: 0px;">
                <p style="text-align: left; font-weight: bold; color: black; font-size: 16px; margin: 0px">檢舉事由：
                    <br/><hr/ style='border-color: #d9b3ff'></p>
                <textarea id="comment" name="comment" style="width: 100%; height: 120px; resize: none;"></textarea><br/><br/>
                <input type='submit'  style='font-family: "Arial", "微軟正黑體";' name='report' value='確認送出' />
<!--                一開始就不用先放值-->
                <input id="pet_ID" type='hidden' name='pet_ID' value ="" />
                <input id="gov_ID" type='hidden' name='gov_ID' value="" />
                <input type="submit" onclick='NonDisplay()' value="取消">
            </form>
        </div>
    </div>
</div>
<?php

include("Government_menu.php");
include("Government_function.php");
$government = new government_function();

/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017/12/13
 * Time: 上午 10:35
 */

//由前一頁Get的
$petition_ID = htmlspecialchars($_GET["petition_id"]);

//POST動作
if(array_key_exists('report', $_POST)){
    $government->ReportPetition($_POST["gov_ID"], $_POST["pet_ID"], $_POST["comment"]);
}
if (array_key_exists('confirm', $_POST)){
    if(!empty($_POST["respond_content"])){
        $government->PetitionReply($_POST["gov_id"], $_POST["pet_id"], $_POST["respond_content"]);
    }
}

//使用者陳情內容
echo "<h1 class='h1'>陳情文章</h1>";
$result = $government->ShowPetition($petition_ID);
echo "<table class='table'><tr>";
echo "<td class='td'>使用者:</td>";
echo "<td class='user'>".$result[0]["name"]."</td></tr><tr>";
echo "<td rowspan='3'></td>";
echo "<td class='time'>".$result[0]["publish_date"]."<br/><hr style='border-color: #d9b3ff'/></td></tr><tr>";
echo "<td class='content'>".$result[0]["content"]."</td></tr>";
//檢舉按鈕→可用writeComment新增檢舉事由
//將目前的government_ID及petition_ID傳給function writeComment
echo "<td align='right'><input onclick=\"writeComment('".$gov_id."', '".$petition_ID."')\" type='submit' style='font-family: \"Arial\", \"微軟正黑體\";' name='report' value='檢舉' /></td>";
echo "</table>";
echo "</br></br>";

//已回覆
if (!empty($result[0]["gov_ID"])){
    echo "<table class='table'><tr>";
    echo "<td class='td'>政府人員:</td>";
    $Gov = $government->getGovInfo($result[0]["gov_ID"]);
    echo "<td class='user'>".$Gov[0]["name"]."</td></tr><tr>";
    echo "<td rowspan='3'></td>";
    echo "<td style='font-size: 12px;'>---".$Gov[0]["department"]."---</td></tr><tr>";
    echo "<td class='time'>".$result[0]["complete_date"]."<br/><hr style='border-color: #d9b3ff'/></td></tr><tr>";
    echo "<td class='content'>".$result[0]["respond_content"]."<br/><br/></td></tr>";
}
//未回覆
else{
    echo "<table class='table'>";
    echo "<tr><td class='td'>政府人員:</td>";
    echo "<td class='user'>$name</td></tr>";
    echo "<td rowspan='4'></td>";
    echo "<td style='font-size: 12px;'>---$dep---</td></tr>";
    echo "<td class='time'>".date('Y-m-d')."<br/><hr style='border-color: #d9b3ff'/></td></tr><tr>";
    echo "<form method='post'>";
    echo "<input type='hidden' name='gov_id' value='".$gov_id."' />";
    echo "<input type='hidden' name='pet_id' value='".$petition_ID."' />";
    echo "<td><textarea class='reply' type='text' name='respond_content' placeholder='回覆…'></textarea></td></tr><tr>";
    echo "<td align='right'><input type='submit' style='font-family: \"Arial\", \"微軟正黑體\";' name='confirm' value='確認' /></td></tr>";
    echo "</form>";
}
echo "</table>";
echo "</br></br>";
?>
</body>
</html>