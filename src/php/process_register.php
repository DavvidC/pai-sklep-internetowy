<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = htmlspecialchars($_POST['username']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    if (empty($username) || empty($email) || empty($password)) {
        echo 'Please fill in all required fields.';
    } elseif (!$email) {
        echo 'Provided e-mail address isn\t valid.';
    } else {

        $host = 'localhost';
        $user = 'root';
        $password_db = '';
        $db_name = 'app-db';

        $conn = mysqli_connect($host, $user, $password_db, $db_name);

        if (!$conn) {
            echo 'DB connection error: ' . mysqli_connect_error();
        } else {
            $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
            if (mysqli_query($conn, $sql)) {
                // Przekierowanie po upływie 5 sekund
                header("Refresh: 5; url=../../index.html");
                echo 'Konto zostało utworzone pomyślnie. Zostaniesz przekierowany na stronę główną za 5 sekund...';
                exit();
            } else {
                echo 'Error while creating user: ' . mysqli_error($conn);
            }
            mysqli_close($conn);
        }
    }
}
