<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017/12/12
 * Time: 下午 07:45
 */
require_once ('MysqliDb.php');
//function

class manager_function{
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
            $result = Array('status' => "檢舉成功",'man_ID' => $_SESSION['mID']);
        }
        else{
           $result = Array('status' => "檢舉失敗",'man_ID' => $_SESSION['mID']);
        }
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

    function SearchAccount_normal($search){
        $db = new MysqliDb ();
        $sql = "SELECT * FROM member WHERE 1=1";
        if(empty($search[4])!=1&&empty($search[5])!=1){
            unset($search[4]);
            unset($search[5]);
        }
        for($i=0;$i<6;$i++){
            if(empty($search[$i])!=1){
                if($i==0){$sql=$sql." AND user_ID LIKE '%".$search[$i]."%'";}
                elseif($i==1){$sql=$sql." AND name LIKE '%".$search[$i]."%'";}
                elseif($i==4){$sql=$sql." AND report_num >=1";}
                elseif($i==5){$sql=$sql." AND report_num IS NULL";}
            }
        }//echo($sql);
        $result = $db->rawQuery($sql);
        return($result);
    }

    function SearchAccount_government($search){
        $db = new MysqliDb ();
        $sql = "SELECT * FROM government WHERE 1=1";
        for($i=0;$i<2;$i++){
            if(empty($search[$i])!=1){
                if($i==0){$sql=$sql." AND gov_ID LIKE '%".$search[$i]."%'";}
                elseif($i==1){$sql=$sql." AND name LIKE '%".$search[$i]."%'";}
            }
        }//echo($sql);
        $result = $db->rawQuery($sql);
        return($result);
    }

    function DeleteAccount($delete){
        $db = new MysqliDb ();
        if($delete[0]=="一般民眾"){
            $data = Array ('enable' => '0');
            $db->where('user_ID',$delete[1]);
            $db->update ('member', $data);
        }
        if($delete[0]=="政府人員"){
            $data = Array ('enable' => '0');
            $db->where('gov_ID',$delete[1]);
            $db->update('government', $data);
        }
    }

    function UpdateAccount($update){
        $db = new MysqliDb ();
        if($update[0]=="一般民眾"){
            $data = Array ('passwords' =>$update[2]);
            $db->where ('user_ID', $update[1]);
            $db->update ('member', $data);
        }
        if($update[0]=="政府人員"){
            $data = Array ('passwords' =>$update[2]);
            $db->where ('gov_ID', $update[1]);
            $db->update ('government', $data);
        }
    }

    function NewGovernment($gov_id, $username, $department, $password, $email){
        $db = new MysqliDb ();
        $new= Array ("gov_ID" => $gov_id,
            "name" => $username,
            "department" => $department,
            "passwords" => $password,
            "email" => $email,
            "man_ID" => $_SESSION['mID']
        );
        //=[$userid,$username,$password,$department,$email];
        $gov = $db->insert ('government', $new);  //Table: member
        if($gov)
            echo ("政府人員".$gov_id."新增成功");
    }
}
