<?php
include '../config/database.php';
$database = new Database();
$db = $database->getConnection();
$request_method = $_SERVER["REQUEST_METHOD"];

switch($request_method)
{
    case 'GET':
        if(!empty($_GET["id"]))
        {
            $id = intval($_GET["id"]);
            get_tasks($id);
        }
        else
        {
            get_tasks();
        }
        break;
    case 'POST':
        insert_task();
        break;

    case 'PUT':
        $id = intval($_GET["id"]);
        update_task($id);
        break;

    case 'DELETE':
        $id = intval($_GET["id"]);
        delete_task($id);
        break;

    default:
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

function get_tasks($id=0)
{
    global $db;
    $query= "SELECT * FROM task";
    if($id!=0)
    {
        $query.=" WHERE id=".$id." LIMIT 1";
    }
    $response=array();
    $result=mysqli_query($db, $query);
    while($row=mysqli_fetch_array($result))
    {
        $response[]=$row;
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}

function insert_task()
{
    global $db;
    $data = json_decode(file_get_contents('php://input'), true);
    $user_id = $data["user_id"];
    $title = $data["title"];
    $description = $data["description"];
    $status = $data["status"];
    echo $query="INSERT INTO task SET user_id='".$user_id."', title='".$title."', description='".$description."', status='".$status."'";
    if(mysqli_query($db,$query))
    {
        $response=array(
            'status' => 1,
            'status_message' => 'Task added successfully.'
        );
    }
    else
    {
        $response=array(
            'status' => 0,
            'status_message' => 'Task addition failed.'
        );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}

function update_task($id)
{
    global $db;
    $post_vars = json_decode(file_get_contents("php://input"),true);
    $title=$post_vars["title"];
    $description=$post_vars["description"];
    $status=$post_vars["status"];
    $query="UPDATE task SET title='".$title."', description='".$description."', status='".$status."' WHERE id=".$id;
    if(mysqli_query($db, $query))
    {
        $response=array(
            'status' => 1,
            'status_message' =>'Task updated successfully.'
        );
    }
    else
    {
        $response=array(
            'status' => 0,
            'status_message' =>'Task updation failed.'
        );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}

function delete_task($id)
{
    global $db;
    $query="DELETE FROM task WHERE id=".$id;
    if(mysqli_query($db, $query))
    {
        $response=array(
            'status' => 1,
            'status_message' =>'Task deleted successfully.'
        );
    }
    else
    {
        $response=array(
            'status' => 0,
            'status_message' =>'Task deletion failed.'
        );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}