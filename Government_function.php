<?php
/**
 * Created by PhpStorm.
 * User: Andy
 * Date: 2017/12/18
 * Time: 下午6:05
 */

include("MysqliDb.php");

class Government_function{

    function ShowKeywordStatistic($date_begin, $date_end, $search_type){
        $db = new MysqliDb ();
        $sql = "SELECT search_type, key_word, statistic from";
        $sql .= " (SELECT search_type.`search_type_name` as 'search_type', `key_word`, count(1) as `statistic` FROM `search_record`, `search_type`";
        $sql .= " where search_type.search_type_id=search_record.search_type";
        if ($search_type==1){
            $sql .= " and search_type.search_type_id in ('A1', 'A2')";
        }
        else if($search_type==2){
            $sql .= " and search_type.search_type_id in ('住宅竊盜', '機車竊盜', '汽車竊盜', '自行車竊盜')";
        }
        $sql .= " and search_date >= '".$date_begin."' and search_date < '".$date_end."'";
        $sql .= " GROUP BY search_type.search_type_name, `key_word`) as data";
        $sql .= " order by `statistic` DESC, `search_type`, `key_word`";

        $result =  $db->rawQuery($sql);
        return $result;
    }

    function ShowPetitionCompletionRate($date_begin, $date_end){
        $db = new MysqliDb ();
        $sql = "SELECT `type`, count(1) as `petition_sum`";
        $sql .= " FROM `petition` where `publish_date`>='".$date_begin."' and `publish_date`<'".$date_end."' group by `type`";
        $total =  $db->rawQuery($sql);

        $db = new MysqliDb ();
        $sql = "SELECT type, status, count(1) as `petition_num`, avg(DATEDIFF(complete_date, publish_date)) as `process_spend`";
        $sql .= "  FROM `petition` where `publish_date`>='".$date_begin."' and `publish_date`<'".$date_end."'";
        $sql .= " group by `type`, `status` order by `type`";
        $type =  $db->rawQuery($sql);

        $result = array(0 => $total, 1 => $type);

        return $result;
    }

    function ShowPetitionRecord($dep){
        $db = new MysqliDb ();
        $PetitionRecord = $db->rawQuery('SELECT p.petition_ID,p.publish_date, m.name, p.content, p.status, p.complete_date, p.respond_content,r.status as rep_s,r.man_ID from member as m,petition as p left join report as r on r.petition_ID= p.petition_ID WHERE m.user_ID = p.user_ID AND p.type= "'.$dep.'" ;');
        return $PetitionRecord;
    }
    function ShowPetition($petition_id){
        $db = new MysqliDb ();
        $sql_str = "SELECT p.user_ID, m.name, p.publish_date, p.content, p.gov_ID, p.complete_date, p.respond_content ";
        $sql_str = $sql_str . "FROM petition as p join member as m ";
        $sql_str = $sql_str . "WHERE p.petition_ID = ".$petition_id." and p.user_ID = m.user_ID";
        $petition_reply = $db->rawQuery($sql_str);
        return $petition_reply;
    }

    function PetitionReply($gov_id, $petition_id, $content){
        $db = new MysqliDb();
        $data = Array(
            'gov_ID' => $gov_id,
            'respond_content' => $content,
            'complete_date' => date("Y-m-d"),
            'status' => "已處理"
        );
        $db->where('petition_ID', $petition_id);
        if ($db->update('petition', $data)){
//        echo $db->count.'records were updated';
        }
        else{
//        echo 'update failed: ' . $db->getLastError();
        }
    }

    function ReportPetition($gov_id, $petition_id, $comment){
//    echo $gov_id."  ".$petition_id."   ".$comment;
        $db = new MysqliDb();
        $data = Array(
            "petition_ID" => $petition_id,
            "gov_ID" => $gov_id,
            "comment" => $comment,
            "submit_date" => date('Y-m-d'),
            "status" => "未處理"
        );
        $result = $db->insert('report', $data);
        if($result){
//        echo 'user was created. Id='.$result;
        }
        else{
//        echo 'This is else messages.';
        }
    }

    function getGovInfo($gov_ID){
        $db = new MysqliDb();
        $sql_str = "SELECT g.name, g.department FROM government as g WHERE g.gov_ID = '".$gov_ID."'";
        $result = $db->rawQuery($sql_str);
        return $result;
    }
}