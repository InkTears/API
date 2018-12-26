<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/database.php';
include_once '../objects/tasks.php';

$database = new Database();
$db = $database->getConnection();
$task = new Task($db);
$data->title = $_GET["title"];
$task->title = $data->title;

if($task->delete())
    {
        http_response_code(200);
        echo json_encode(array("message" => "Task was deleted."));
    }

else
    {
        http_response_code(503);
        echo json_encode(array("message" => "Could not delete task, something is wrong."));
    }
