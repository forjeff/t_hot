<?php
include("Government_function.php");
$government = new Government_function();
include("Government_menu.php")
//測試
/*if (empty($gov_id)){
	$gov_id="1";
	$dep="交通";
}*/

?>
<html>
    <head>
        <meta charset="UTF-8" >
        <title>查看陳情紀錄</title>
		<link rel="stylesheet" href="Show_petition_record.css"> 
    </head>
    <body>
	
	<?php
    $Petition = $government -> ShowPetitionRecord($dep);
    ?>
		<center> 
		<table  border="0" align="center width="500" height="100" >
　		<tr><td align="center" valign="center"><font size="15" face="微軟正黑體">
		查看陳情紀錄</font></td></tr>
		</table>
		</center>
			<table  align="center" class="table table-striped">
				<thead><tr>
					<th align="center" valign="middle">日期</th>
					<th align="center" valign="middle">陳情人</th>
					<th align="center" valign="middle">陳情內容</th>
					<th align="center" valign="middle">處理狀態</th>
					<th align="center" valign="middle">回覆時間</th>
				</thead></tr>
				<tbody>
				<?php
					foreach ($Petition as $Petitions) {
						$petition_id=$Petitions['petition_ID'];
						if($Petitions['rep_s']==null){
							echo '<tr><td align="center">'.$Petitions['publish_date'].'</td><td align="center">'.$Petitions['name'].'</td><td align="center">'.$Petitions['content'].'</td><td align="center"><a href="Petition_Reply.php?petition_id='.$petition_id.'">'.$Petitions['status'].'</a></td><td align="center">'.$Petitions['complete_date'].'</td></tr>';
						}
						elseif($Petitions['rep_s']=='檢舉失敗'){
							echo '<tr><td align="center">'.$Petitions['publish_date'].'</td><td align="center">'.$Petitions['name'].'</td><td align="center">'.$Petitions['content'].'</td><td align="center"><a href="Petition_Reply.php?petition_id='.$petition_id.'">'.$Petitions['rep_s'].',回應：'.$Petitions['man_ID'].'</a></td><td align="center">'.$Petitions['complete_date'].'</td></tr>';
						}
						elseif($Petitions['rep_s']=='檢舉成功')
							echo '<tr><td align="center">'.$Petitions['publish_date'].'</td><td align="center">'.$Petitions['name'].'</td><td align="center">'.$Petitions['content'].'</td><td align="center">'.'檢舉進度 :'.$Petitions['rep_s'].',回應人員：'.$Petitions['man_ID'].'</td><td align="center">'.'---------'.'</td></tr>';
						else
							echo '<tr><td align="center">'.$Petitions['publish_date'].'</td><td align="center">'.$Petitions['name'].'</td><td align="center">'.$Petitions['content'].'</td><td align="center">'.'檢舉進度 :'.$Petitions['rep_s'].',回應人員：'.$Petitions['man_ID'].'</td><td align="center">'.$Petitions['complete_date'].'</td></tr>';
					}
				?>
				</tbody>
			</table>
    </body>
</html>
