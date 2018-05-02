<?php require_once ('MysqliDb.php');

$db = new MysqliDb ();
include('Member_function.php');
$member=new Member_function();
include('Member_menu.php');

if(array_key_exists("num", $_POST))
{
    $num = $_POST["num"];
    /*echo "Delete Num: ".$num;*/
    $success=$member->DeletePetitionRecord($num);
    if($success==true)

    echo "<script>alert('已刪除陳情紀錄');</script>";
}

?>
<html>
<head>
<title>個人陳情紀錄</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<?php
$searchs = $member->ShowPetitionRecord($user_id);
?>

<center> 
<table  border="0" align="center width="500" height="100" >
　<tr><td align="center" valign="center"><font size="15" face="微軟正黑體">
<?php 
if( count($searchs)==0){
echo "查無搜尋紀錄";
}
else{
echo  $name."的陳情紀錄";}

?></font></td></tr>
</table>
</center> 

<table class="table table-striped">
    <thead>
        <tr>
            <th>陳情日期</th>
            <th>陳情內容</th>
            <th>處理狀態</th>
            <th>回覆日期</th>
            <th>政府回覆內容</th>
            <th>刪除紀錄</th>
        </tr>
    </thead>
<?php
	
	
	
    /*
	$db->where ("user_ID","H124418879");
	  $searchs = $db->get ("search_record");
	  if ($db->count > 0)
	  foreach ($searchs as $search){
	*/
	foreach ($searchs as $search){
 ?>
    
    <tbody>
    <tr>
     
        <td align="center" valign="middle"><?php echo $search['publish_date'];?></td>
        <td align="center" valign="middle"><?php echo $search['content'];?></td>
        <td align="center" valign="middle"><?php echo $search['status'];?></td>
        <td align="center" valign="middle"><?php echo $search['complete_date'];?></td>
        <td align="center" valign="middle"><?php echo $search['respond_content'];?></td>
        <td align="center" valign="middle"><?php echo "<form action='Search_petition.php' method='POST'>" ?>
			<?php echo "<input type='hidden' name='num' value='".$search['petition_ID']."'/>"			?>
			<input type="submit" <?php if($search['status']=="已處理"){ echo "disabled"; }?>  value="刪除"/>
		</form></td>
    </tr>
	</tbody>
	
<?php }

?>
</table>
</body>
</html>