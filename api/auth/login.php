<?php
include('../connection/database.php');
include('../admin/header.php');

function validate($data)
{
    $data = strip_tags($data);
    $data = htmlspecialchars($data);
    $data = trim($data);
    return $data;
}

$email = validate($_POST['email']) ?? '';
$Password = validate($_POST['password']) ?? '';


if (empty($email && $Password)) {
    $jsonResponse = ['success' => false, 'message' => 'all input is required'];
    echo json_encode($jsonResponse);
} elseif (!strpos($email, '@gmail.com')) {
    $jsonResponse = ['success' => false, 'message' => 'Invalid Email'];
    echo json_encode($jsonResponse);
} else {
    $check = "SELECT * FROM rydon_user_schema WHERE email = '$email' AND password = '$Password'";
    $queryThis = $connection->query($check);
    $count = mysqli_num_rows($queryThis);

    if ($count > 0) {
        $row = mysqli_fetch_assoc($queryThis);
        session_start();
        $_SESSION['name'] = $row['username'];
        $_SESSION['online'] = true;
        $_SESSION['userid'] = $row['userid'];
        $_SESSION['email'] = $row['email'];
        $id = $row['userid'];
        $name = $row['username'];

        $userinformation = ['success' => true, 'message' => "welcome $name"];
        setcookie(session_name(), session_id(), time() + (86400 * 30), "/");
        echo json_encode($userinformation);
    } else {
        $jsonResponse = ['success' => false, 'message' => "invalid email and password"];
        echo json_encode($jsonResponse);
    }
}