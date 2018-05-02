<?php require_once ('MysqliDb.php'); 

class Member_function{

    function ShowSearchRecord($user_id){
        $db = new MysqliDb ();
        $searchs = $db->rawQuery("SELECT search_record.record_ID, search_record.user_ID, member.name, search_record.key_word, 
search_type.search_type_name, search_record.search_date
  from search_record ,member, search_type
  WHERE search_record.user_ID ='".$user_id."'
  AND member.user_ID = search_record.user_ID
  AND search_record.search_type = search_type.search_type_id;");


        return $searchs;

    }

    function DeleteSearchRecord($num){
        $db = new MysqliDb ();
        $db->where('record_ID', $num);
        if($db->delete('search_record')){

            return true;

        }

        else{

            return false;
        }
    }

    function ShowPetitionRecord($user_id){

        $db = new MysqliDb ();
        $searchs = $db->rawQuery('SELECT petition_ID, publish_date, content, status, complete_date, respond_content 
            from petition WHERE user_ID ="'.$user_id.'" order by petition_ID ASC;');

        return $searchs;

    }

    function DeletePetitionRecord($num){

        $db = new MysqliDb ();
        $db->where('petition_ID', $num);
        if($db->delete('petition')){

            return true;

        }

        else{

            return false;
        }
    }

    function NewPetition($user_id, $type, $content){
        $db = new MysqliDb ();
        $data = Array ("user_ID" => $user_id,
            "status" => "未處理",
            "content" => $content,
            "type" => $type,
            "publish_date" => date("Y-m-d"),
            "gov_ID" => ""
        );
        $db->insert ('petition', $data);
    }

    function search(){
        // isset() 方法檢測變數是否設置；empty() 方法判斷值是否為空
        // 超全域變數 $_GET 和 $_POST 用於收集表單資料
        if (!isset($_POST['id_address']) || empty($_POST['id_address'])) {
            echo " 沒有輸入身份ID ";
            return;
        }

        $db = new MysqliDb ();
        $db->where ("user_ID",$_POST['id_address']);
        $user = $db->getOne ("member");
        if($user['user_ID']==""){
            echo " 此ID可以使用 ";
            return;
        }
        echo "此ID已註冊過";
    }

    
    function create() {
        // 如果員工資料未填寫完全
        $db = new MysqliDb ();
        if (!isset($_POST['name']) || empty($_POST['name']) ||
            !isset($_POST['email']) || empty($_POST['email']) ||
            !isset($_POST['password']) || empty($_POST['password']) ||
            !isset($_POST['confirm']) || empty($_POST['confirm']) ||
            !isset($_POST['gender']) || empty($_POST['gender']) ||
            !isset($_POST['birthday']) || empty($_POST['birthday']) || 
            !isset($_POST['id_address']) || empty($_POST['id_address'])){
                echo "員工資料未填寫完全";
                return;}
        elseif($_POST['password'] != $_POST['confirm']){
            echo "密碼與確認不相同";
            return;
        }
        elseif($_POST['check1']=="f"){
            echo "ID格式錯誤";
            return;
        }
        elseif(!preg_match("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/",$_POST['birthday'])){
            echo "生日格式錯誤";
            return;
        }
        elseif(!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $_POST["email"])){
            echo "信箱格式錯誤";
            return ;
        }
        else{
            $data = Array ("user_ID" => $_POST['id_address'],
                "name" =>  $_POST['name'],
                "email" => $_POST['email'],
                "passwords" =>  $_POST['password'],
                "birth" => $_POST['birthday'],
                "gender" => $_POST['gender'],
                "disable_deadline" => "1111-11-11"
            );
            $id = $db->insert ('member', $data);  //Table: member
            if($id){
                echo "ok";
                return;
            }
            else{
                echo "fail";
            }
        }
    }

    function ShowAllPetition(){

        $db = new MysqliDb ();
        $db->join("petition u", "p.petition_ID=u.petition_ID", "RIGHT OUTER");
        $db->groupBy ("u.petition_ID");
        $products = $db->get ("petition_evalution p",null,"u.petition_ID,avg(p.rank)");
        if ($db->count > 0){
            // echo $db->count;
            foreach ($products as $product) {
                if(is_null($product['avg(p.rank)'])){
                    $product['avg(p.rank)']=0;
                    // echo $product['avg(p.rank)'];
                }
            }
        }
	
	$db = new MysqliDb ();
        $db->join("petition p", "p.user_ID=m.user_ID", "RIGHT OUTER");
        $cols = Array ("petition_ID","status","content","type","publish_date,gender");
        $pets = $db->get ("member m", null,$cols);
        if ($db->count > 0){
            for($i=0;$i<count($pets);$i++){
                $pets[$i]['rank']=$products[$i]['avg(p.rank)'];
            }
            return $pets;
        }
    }

    function ShowReportedPetition(){
        $db = new MysqliDb ();
        $sql_str = "SELECT r.submit_date as 'time', r.petition_ID, p.user_ID, p.content, r.gov_ID, r.comment, r.status ";
        $sql_str = $sql_str . "FROM report as r left join petition as p on r.petition_ID = p.petition_ID";
        $reported_petition = $db->rawQuery($sql_str);
        return $reported_petition;
    }

    function VerifyReportedPetition($petition_id, $whether_disable)
    {
        $db = new MysqliDb ();
        $sql_str = "SELECT user_ID FROM petition WHERE petition_ID=$petition_id";
        $user_id = $db->rawQuery($sql_str);

        if ($whether_disable) {
            self::DisableMember($user_id[0]["user_ID"]);
        }

        $result = Array('status' => "已處理");
        $db->where('petition_ID', $petition_id);
        if ($db->update('report', $result)) {
//        echo $db->count . ' records were updated';
//        echo "<br/>";
        } else {
//        echo 'update failed: ' . $db->getLastError();
        }
    }

    function DisableMember($user_id)
    {
        $db = new MysqliDb ();
        $sql_str = "SELECT report_num FROM member WHERE user_ID='" . $user_id . "'";
        $report_num = $db->rawQuery($sql_str);
        $report_num = $report_num[0]["report_num"];
        if (is_null($report_num))
            $report_num = 0;
        $result = Array(
            'report_num' => $report_num + 1,
            'disable_deadline' => date("Y-m-d", strtotime("+7 day"))
        );
        $db->where('user_ID', $user_id);
        if ($db->update('member', $result)) {
//        echo $db->count . ' records were updated';
//        echo "<br/>";
        } else {
//        echo 'update failed: ' . $db->getLastError();
        }
    }
    function update(){
        $db = new MysqliDb ();
        $data = Array();//創建array
        if($_POST['password'] != $_POST['confirm']){
            echo "密碼與確認不相同";
            return;
        }
        elseif(!empty($_POST['password']))//有輸入密碼
            //array_push($data,"'passwords' =>  ".$_POST['password']."");原本錯的做法
            //用法array_push($data,"aa","bb");
            $data['passwords']=$_POST['password'];//重要的bug解決之道
        if(!empty($_POST['name'])){
            $data['name']=$_POST['name'];
            // array_push($data,"'name' =>  ".$_POST['name']."");
        }
        if(!empty($_POST['birthday'])){//生日有填
            if(!preg_match("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/",$_POST['birthday'])){
                echo "生日格式錯誤";
                return;               
            }
            else 
                $data['birth']=$_POST['birthday'];
        }
        if(!empty($_POST['email'])){//EMAIL有填
            if(!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $_POST["email"])){//email錯誤
                echo "信箱格式錯誤";
                 return ;
            }
            else
                $data['email']=$_POST['email'];
        }
        //print_r ($data);
       // $db->where('user_ID',"".$_POST['id']."");
        $db->where('user_ID',$_POST['id']);
        $id = $db->update('member', $data);  //Table: member
        if($id){
           echo "ok";
           if(!empty($_POST['name'])){
                session_start();
              $_SESSION['name']=$_POST['name'];}
           return;
        }
        else{
            echo "fail";
        }
    }
    /*$data = Array (
        'name' => '我愛軟工'.rand(0,100)
    );
    $db->where ('user_ID', 'A146665053');
    if ($db->update ('member', $data))*/
    function EvaulateGovernmentPerformance(){
        if (!isset($_POST['content']) || empty($_POST['content']) ||
        !isset($_POST['star']) || empty($_POST['star'])) {
             echo json_encode(array('msg' => '請給予政府表現分數和評論！'));
            return;
        }
        $db = new MysqliDb ();
        $data = Array (
            "content" => $_POST['content'],
            "rank" => $_POST['star'],
            "submit_date" =>$_POST['date'],
            "petition_ID" => $_POST['pid'],
            "user_ID" =>$_POST['uid'],
        );
        $id=$db->insert('petition_evalution',$data);
        if($id){
            echo json_encode(array('msg' => "1"));
            return;}
        else{
            echo json_encode(array('msg' => '2'));
            return;
        }
    }
    function ShowPetition($petition_id){
        $db = new MysqliDb ();
        $sql_str = "SELECT p.user_ID, m.name, p.publish_date, p.content, p.gov_ID, p.complete_date, p.respond_content ";
        $sql_str = $sql_str . "FROM petition as p join member as m ";
        $sql_str = $sql_str . "WHERE p.petition_ID = ".$petition_id." and p.user_ID = m.user_ID";
        $petition_reply = $db->rawQuery($sql_str);
        return $petition_reply;
    }
    function getGovInfo($gov_ID){
        $db = new MysqliDb();
        $sql_str = "SELECT g.name, g.department FROM government as g WHERE g.gov_ID = '".$gov_ID."'";
        $result = $db->rawQuery($sql_str);
        return $result;
    }
    function PetitionEvalutionState($uid, $pid){
        $db=new MysqliDb();
        $db->where ("user_ID",$uid);
        $db->where ("petition_ID",$pid);
        $user = $db->getOne ("petition_evalution");
        return $user;
    }

    function getSearchTypeList($type){
        $db=new MysqliDb();
        $sql_str = "select search_type_id, search_type_name from search_type where type = '".$type."';";
        $list = $db->rawQuery($sql_str);
        return $list;
    }
}












?>