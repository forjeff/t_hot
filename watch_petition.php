<?php
  //echo $_GET['id']; 
  require_once("Member_menu.php");
  include("Member_function.php");
  $member = new Member_function();
  echo "<h1 class='h1'>陳情文章</h1>";
  $petition_ID = htmlspecialchars($_GET['id']);
  $result = $member->ShowPetition($petition_ID);
  echo "<table class='table'><tr>";
  echo "<td class='td'>文章作者:</td>";
  echo "<td class='user'>".$result[0]["name"]."</td></tr><tr>";
  echo "<td rowspan='3'></td>";
  echo "<td class='time'>"."陳情日期 ：".$result[0]["publish_date"]."<br/><hr style='border-color: #BDB76B'/></td></tr><tr>";
  echo "<td class='content'>".$result[0]["content"]."</td></tr>";
  echo "<br/><br/>";
  //檢舉按鈕→可用writeComment新增檢舉事由
  //將目前的government_ID及petition_ID傳給function writeComment
  ////echo "<td align='right'><input onclick=\"writeComment('".$gov_id."', '".$petition_ID."')\" type='submit' style='font-family: \"Arial\", \"微軟正黑體\";' name='report' value='檢舉' /></td>";
  //政府人員已已回覆
if (!empty($result[0]["gov_ID"])){
  echo "<table class='table'><tr>";
  echo "<td class='td'>政府人員:</td>";
  $mem = $member->getGovInfo($result[0]["gov_ID"]);
  echo "<td class='user'>".$mem[0]["name"]."</td></tr><tr>";
  echo "<td rowspan='3'></td>";
  echo "<td style='font-size: 12px;'>---".$mem[0]["department"]."---</td></tr><tr>";
  echo "<td class='time'>"."回覆日期 :".$result[0]["complete_date"]."<br/><hr style='border-color: #BDB76B'/></td></tr><tr>";
  echo "<td class='content'>".$result[0]["respond_content"]."<br/><br/></td></tr>";
  echo "<br/><br/>";
}
$check=$member->PetitionEvalutionState($user_id,$petition_ID);
  if(empty($check["user_ID"])){//還沒填寫評論
    echo "<table class='table' id='insert'>";
    echo "<tr><td class='td'>使用者:</td>";
    echo "<td id='name' class='user'>$name</td></tr>";
    echo "<input type='hidden' id='uid' value='".$user_id."' />";
    //echo "<td id='time' class='time'>"."今天日期：".date('Y-m-d')."<br/><hr style='border-color: #BDB76B' /></td></tr><tr>";
    //echo "<input type='hidden' name='gov_id' value='".$gov_id."' />";
    echo "<tr><td><input class='reply' id='pid' type='hidden' name='pet_id' value='".$petition_ID."' />";
    echo "<select name='point' class='opts'>";
    echo "<option selected value='5'>5顆星</option>";
    echo "<option value='4'>4顆星</option>";
    echo "<option value='3'>3顆星</option>";
    echo "<option value='2'>2顆星</option>";
    echo "<option value='1'>1顆星</option>";
    echo "</select></td>";
    echo "<td><textarea id='text' class='reply' type='text' style='height:80px;font-size:11pt;' name='respond_content' placeholder='請給予回饋…'></textarea></td></tr><tr>";
    echo "<td>";
    echo "<p align='right' id='error' style='color:#8B0000;'></p></td><td align='center'><button type='button' id='save' name='confirm'>送出</button></td></tr>";
    echo "<br/><br/>";
  }
  else{
    echo "<table class='table'><tr>";
    echo "<td class='td'>使用者:</td>";
    echo "<td class='user'>".$name."</td></tr><tr>";
    echo "<td rowspan='3'></td>";
    echo "<td class='time'>"."評分日期 ：".$check["submit_date"]."<br/><hr style='border-color: #BDB76B'/></td></tr><tr>";
    echo "<td class='content'>".$check["content"]."</td></tr>";
    echo "<br/><br/>";   
  }
?>
<html lang="en">
    <head>
          <title>使用者陳情文章</title>
         <link rel="stylesheet" href="watch.css">
         <meta charset="utf-8">
        <style type="text/css">
        </style>    
        <script src="jquery-3.2.1.min.js"></script>
        <script src="bootstrap.min.js"></script>
    </head>
    <body>
    <script type="text/Javascript">
  		   $(document).ready(function() {
            $("#save").click(function() {
					    //document.write($("select[name='point']").val());
              var d=new Date();
              //document.write($("#pid").val());
              var YMD=d.getFullYear()+"-"+(d.getMonth()+1)+"-"+d.getDate();
              //$("#insert").html("<hr style='border-color: #BDB76B'/>");
				    	$.ajax({
					    	url: "Member_handler.php",
				  	  	data: {
				  	  		state: '4',
			  	  			content : $("#text").val(),
                  star : $("select[name='point']").val(),
                  date : YMD,
                  pid : $("#pid").val(),
                  uid : $("#uid").val()
			  	  		},
			  	  		type:"POST",
			  	  		dataType:'json',
			  	  		success: function(data) {
                  if(data.msg=="1")
                      $("#insert").html("<table class='table'><tr><td class='td'>使用者:</td><td class='user'>"+$("#name").val()+"</td></tr><tr><td rowspan='3'></td><td class='time'>評論日期 ："+YMD+"<br/><hr style='border-color: #BDB76B'/></td></tr><tr><td class='content'>"+$("#text").val()+"</td></tr><br/><br/>");
                  else if(data.msg=="2")
                     $("#error").html("寫入資料庫錯"); 	
                  else 
                    $("#error").html(data.msg); 	
			  	  		},
			  	  		error: function(jqXHR) {
			  	  			document.write("發生錯誤: " + jqXHR.status);
			  	  		}
			  	  	})
			    	})
          })
        </script>
    </body>
</html>
