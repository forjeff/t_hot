<?php
/**
 * Created by PhpStorm.
 * User: Andy
 * Date: 2017/12/13
 * Time: 上午10:45
 */

require_once ("Member_function.php");
require_once ('MysqliDb.php');
date_default_timezone_set('Asia/Taipei');

function SearchCrimeRoad($type){
    $db = new MysqliDb ();
    $cols = Array("type", "latitude", "longitude");
    $db->where ("type", $type, "=");
    $result =  $db->get("open_data_theft", null, $cols);
    return $result;
}

function SaveSearchCrimeRoadRecord($user_id, $keyword, $type){
    $db = new MysqliDb ();
    $data = Array (
        "user_ID" => $user_id,
        "key_word" => $keyword,
        "search_type" => $type,
        "search_date" => date('Y-m-d H:i:s'),
    );
    $id = $db->insert ('search_record', $data);  //Table: member
    if($id){
        // do nothing
    }
    else{
        echo 'This is else messages.';
    }
}

function SearchAccidentRoad($type){
    $db = new MysqliDb ();
    $cols = Array("type", "latitude", "longitude");
    $db->where ("type", $type, "=");
    $result = $db->get("open_data_traffic_accident", null, $cols);
    return $result;
}

function SaveSearchAccidentRoadRecord($user_id, $keyword, $type){
    $db = new MysqliDb ();
    $data = Array (
        "user_ID" => $user_id,
        "key_word" => $keyword,
        "search_type" => $type,
        "search_date" => date('Y-m-d H:i:s'),
    );
    $id = $db->insert ('search_record', $data);  //Table: member
    if($id){
        // do nothing
    }
    else{
        echo 'This is else messages.';
    }
}

if (array_key_exists("fun_name", $_POST)){
    if ($_POST["fun_name"]=="SearchCrimeRoad"){
        $result = SearchCrimeRoad($_POST["type"]);
        echo json_encode($result);
    }

    if($_POST["fun_name"]=="SaveSearchCrimeRoadRecord"){
        SaveSearchCrimeRoadRecord($_POST["user_id"], $_POST["keyword"], $_POST["type"]);
    }

    if($_POST["fun_name"]=="SearchAccidentRoad"){
        $result = SearchAccidentRoad($_POST["type"]);
        echo json_encode($result);
    }

    if($_POST["fun_name"]=="SaveSearchAccidentRoadRecord"){
        SaveSearchAccidentRoadRecord($_POST["user_id"], $_POST["keyword"], $_POST["type"]);
    }
}

if (array_key_exists("state", $_POST)) {
    if ($_POST['state'] == '1') {
        $member = new Member_function();
        $result = $member->search();
    }
    if ($_POST['state'] == '2') {
        $member = new Member_function();
        $result = $member->create();
    }
    if($_POST['state']=='3'){
        $member = new Member_function();
        $result = $member->update();
    }
    if($_POST['state']=='4'){
        $member =new Member_function();
        $result =$member->EvaulateGovernmentPerformance();
    }
}

?>