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
            get_users($id);
        }
        else
        {
            get_users();
        }
        break;
    case 'POST':
        insert_user();
        break;

    case 'PUT':
        $id = intval($_GET["id"]);
        update_user($id);
        break;

    case 'DELETE':
        $id = intval($_GET["id"]);
        delete_user($id);
        break;

    default:
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

function get_users($id=0)
{
    global $db;
    $query= "SELECT * FROM user";
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

function insert_user()
{
    global $db;
    $data = json_decode(file_get_contents('php://input'), true);
    $user_name = $data["name"];
    $user_email = $data["email"];
    echo $query="INSERT INTO user SET name='".$user_name."', email='".$user_email."'";
    if(mysqli_query($db,$query))
    {
        $response=array(
            'status' => 1,
            'status_message' => 'User added successfully.'
        );
    }
    else
    {
        $response=array(
            'status' => 0,
            'status_message' => 'User addition failed.'
        );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}

function update_user($id)
{
    global $db;
    $post_vars = json_decode(file_get_contents("php://input"),true);
    $user_name=$post_vars["name"];
    $user_email=$post_vars["email"];
    $query="UPDATE user SET name='".$user_name."', email='".$user_email."' WHERE id=".$id;
    if(mysqli_query($db, $query))
    {
        $response=array(
            'status' => 1,
            'status_message' =>'User updated successfully.'
        );
    }
    else
    {
        $response=array(
            'status' => 0,
            'status_message' =>'User updation failed.'
        );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}

function delete_user($id)
{
    global $db;
    $query="DELETE FROM user WHERE id=".$id;
    if(mysqli_query($db, $query))
    {
        $response=array(
            'status' => 1,
            'status_message' =>'User deleted successfully.'
        );
    }
    else
    {
        $response=array(
            'status' => 0,
            'status_message' =>'User deletion failed.'
        );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}