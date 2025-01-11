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
$username = validate($_POST['username']) ?? '';
$email = validate($_POST['email']) ?? '';
$Password = validate($_POST['password']) ?? '';


if (empty($username && $email && $Password)) {
    $jsonResponse = ['success' => false, 'message' => 'all input is required'];
    echo json_encode($jsonResponse);
    echo json_encode($jsonResponse);
} elseif (!strpos($email, '@gmail.com')) {
    $jsonResponse = ['success' => false, 'message' => 'Invalid Email'];
    echo json_encode($jsonResponse);
} else {
    $userid = 'user' . rand();
    //check to see if the email exist already

    $check = "SELECT * FROM fv_user WHERE email = '$email'";
    $queryThis = $connection->query($check);
    $count = mysqli_num_rows($queryThis);
    if ($count > 0) {
        while ($row = mysqli_fetch_assoc($queryThis)) {
            if ($email == $row['email']) {
                $jsonResponse = ['success' => false, 'message' => 'this email already exist'];
                echo json_encode($jsonResponse);
            }
        }
    } else {
        $statement = $connection->prepare("INSERT INTO fv_user(userid, username, email, password) VALUES(?, ?, ?, ?)");
        $statement->bind_param('ssss', $userid, $username, $email, $Password);
        if ($statement->execute()) {
            $jsonResponse = ['success' => true, 'message' => 'Account has been created succesfully'];
            echo json_encode($jsonResponse);
        }
    }
}
?>