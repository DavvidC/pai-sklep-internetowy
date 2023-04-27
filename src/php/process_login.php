<?php

session_start();

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];

    if(empty($email) || empty($password)) {
        echo 'Please fill in all required fields.';
    } else {

        $host = 'localhost';
        $user = 'root';
        $password_db = '';
        $db_name = 'app-db';

        $conn = mysqli_connect($host, $user, $password_db, $db_name);

        if(!$conn) {
            echo 'DB connection error: ' . mysqli_connect_error();
        } else {
            $sql = "SELECT * FROM users WHERE email='$email'";
            $result = mysqli_query($conn, $sql);

            if(mysqli_num_rows($result) > 0) {
                $user = mysqli_fetch_assoc($result);
                if(password_verify($password, $user['password'])) {
                    $_SESSION['logged_in'] = true;
                    $_SESSION['user_id'] = $user['id'];
                    session_regenerate_id();
                    header('Location: index.html');
                } else {
                    echo 'Invalid login details';
                }
            } else {
                echo 'Invalid login details';
            }
            mysqli_close($conn);
        }
    }
}

?>