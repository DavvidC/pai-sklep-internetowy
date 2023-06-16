<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $username = htmlspecialchars($_POST['username']);
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        if (empty($username) || empty($email) || empty($password)) {
            echo 'Please fill in all required fields.';
        } elseif (!$email) {
            echo 'Provided e-mail address is not valid.';
        } else {

            $host = 'localhost';
            $user = 'root';
            $password_db = '';
            $db_name = 'app-db';

            $conn = mysqli_connect($host, $user, $password_db, $db_name);

            if (!$conn) {
                echo 'DB connection error: ' . mysqli_connect_error();
            } else {
                $check_email_sql = "SELECT * FROM users WHERE email = '$email'";
                $result = mysqli_query($conn, $check_email_sql);

                if (mysqli_num_rows($result) > 0) {
                    echo 'This e-mail address is already registered.';
                } else {
                    $insert_user_sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";

                    if (mysqli_query($conn, $insert_user_sql)) {
                        header("Refresh: 5; url=../pages/mainpage.php");
                        echo 'Account created successfully. You will be redirected to the main page in 5 seconds...';
                        exit();
                    } else {
                        echo 'Error while creating user: ' . mysqli_error($conn);
                    }
                }
                mysqli_close($conn);
            }
        }
    }
?>