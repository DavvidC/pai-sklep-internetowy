<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $username = htmlspecialchars($_POST['username']);
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $firstname = htmlspecialchars($_POST['firstname']);
        $surname = htmlspecialchars($_POST['surname']);
        $delivery_address = htmlspecialchars($_POST['delivery_address']);

        if (empty($username) || empty($email) || empty($password) || empty($firstname) || empty($surname) || empty($delivery_address)) {
            echo 'Proszę wypełnić wszystkie pola.';
        } elseif (!$email) {
            echo 'Podany adres e-mail jest nieprawidłowy.';
        } else {

            $host = 'localhost';
            $user = 'root';
            $password_db = '';
            $db_name = 'app-db';

            $conn = mysqli_connect($host, $user, $password_db, $db_name);

            if (!$conn) {
                echo 'Błąd połączenia bazy danych: ' . mysqli_connect_error();
            } else {
                $check_email_sql = "SELECT * FROM users WHERE email = ?";
                $check_email_stmt = mysqli_prepare($conn, $check_email_sql);
                mysqli_stmt_bind_param($check_email_stmt, "s", $email);
                mysqli_stmt_execute($check_email_stmt);
                $result = mysqli_stmt_get_result($check_email_stmt);

                if (mysqli_num_rows($result) > 0) {
                    echo 'Ten adres email jest już zarejestrowany.';
                } else {
                    $insert_user_sql = "INSERT INTO users (username, email, password, firstname, surname, delivery_address) VALUES (?, ?, ?, ?, ?, ?)";
                    $insert_user_stmt = mysqli_prepare($conn, $insert_user_sql);
                    mysqli_stmt_bind_param($insert_user_stmt, "ssssss", $username, $email, $password, $firstname, $surname, $delivery_address);

                    if (mysqli_stmt_execute($insert_user_stmt)) {
                        header("Refresh: 5; url=../pages/mainpage.php");
                        echo 'Konto utworzone pomyślnie. Za 5 sekund zostaniesz przekierowany na stronę główną...';
                        exit();
                    } else {
                        echo 'Błąd podczas tworzenia użytkownika: ' . mysqli_error($conn);
                    }
                }
                mysqli_close($conn);
            }
        }
    }
?>