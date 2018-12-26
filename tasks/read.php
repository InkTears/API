<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/database.php';
include_once '../objects/tasks.php';

$database = new Database();
$db = $database->getConnection();
$task = new Task($db);
$state = $task->read();
$num = $state->rowCount();

if($num>0){

    $tasks_arr=array();
    $tasks_arr["records"]=array();

    while ($row = $state->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $task_item=array(
            "user_id" => $user_id,
            "title" => $title,
            "description" => $description,
            "creation_date" => $creation_date,
            "status" => $status,
        );
        array_push($tasks_arr["records"], $task_item);
    }
    http_response_code(200);
    echo json_encode($tasks_arr);
}
else{
    http_response_code(404);
    echo json_encode(
        array("message" => "No task found.")
    );
}