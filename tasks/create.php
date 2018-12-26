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

$data->user_id = $_GET["user_id"];
$data->title = $_GET["title"];
$data->description = $_GET["description"];
$data->status = $_GET["status"];

if(!empty($data->user_id) && !empty($data->title) && !empty($data->description) && !empty($data->status))
    {
        $task->user_id = $data->user_id;
        $task->title = $data->title;
        $task->description = $data->description;
        $task->status = $data->status;
        if($task->create())
        {
            http_response_code(201);
            echo json_encode(array("message" => "Task was created."));
        }
        else
        {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to create task."));
        }
    }
else
    {
        http_response_code(400);
        echo json_encode(array("message" => "Unable to create task. Something is missing."));
    }
