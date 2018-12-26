<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
include_once '../config/database.php';
include_once '../objects/tasks.php';

$database = new Database();
$db = $database->getConnection();
$task = new Task($db);
$task->title = isset($_GET['title']) ? $_GET['title'] : die();
$task->readTask();

if($task->title!=null)
    {
        $task_arr = array(
            "user_id" =>  $task->user_id,
            "title" => $task->title,
            "description" => $task->description,
            "creation_date" => $task->creation_date,
            "status" => $task->status
        );

        http_response_code(200);
        echo json_encode($task_arr);
    }

else
    {
        http_response_code(404);
        echo json_encode(array("message" => "Task does not exist or wrong title."));
    }