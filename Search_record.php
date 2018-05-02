<?php
    require_once ('MysqliDb.php');
    $db = new MysqliDb ();
    include('Member_function.php');
    $member=new Member_function();
    include('Member_menu.php');

    if(array_key_exists("num", $_POST))
    {
        $num = $_POST["num"];
        $success=$member->DeleteSearchRecord($num);
        if($success==true)
            echo "<script>alert('已刪除搜尋紀錄');</script>";
    }
?>
<html>
<head>
<title>個人查詢紀錄</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<?php 
$searchs = $member->ShowSearchRecord($user_id);

?>
<center> 
<table  border="0" align="center width="500" height="100" >
　<tr><td align="center" valign="center"><font size="15" face="微軟正黑體"><?php 

if( count($searchs)==0){
echo "查無搜尋紀錄";
}
else{
echo $name. "的搜尋紀錄";}


?></font></td></tr>
</table>
</center> 

   <table class="table table-striped">
  <thead>
    <tr>
      <th>關鍵字</th>
      <th>搜尋類型</th>
      <th>搜尋時間</th>
	  <th>  &nbsp;  </th>
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
                <td align="center" valign="middle"><?php echo $search['key_word'];?></td>
                <td align="center" valign="middle"><?php echo $search['search_type_name'];?></td>
                <td align="center" valign="middle"><?php echo $search['search_date'];?></td>
                <td align="center" valign="middle"><?php echo "<form action='Search_record.php' method='POST'>" ?>
                    <?php echo "<input type='hidden' name='num' value='".$search['record_ID']."'/>" ?>
                    <input type="submit" value="刪除"/>
                    </form></td>
            </tr>
	    </tbody>

<?php }

?>
    </table>
</body>
</html>