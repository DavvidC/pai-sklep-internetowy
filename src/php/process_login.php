<?php
    session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        $password = $_POST['password'];

        if (empty($email) || empty($password)) {
            echo 'Proszę uzupełnić wszystkie pola.';
        } else {

            $host = 'localhost';
            $user = 'root';
            $password_db = '';
            $db_name = 'app-db';

            $conn = mysqli_connect($host, $user, $password_db, $db_name);

            if (!$conn) {
                echo 'Błąd połączenia bazy danych: ' . mysqli_connect_error();
            } else {
                // Użyj parametryzowanych zapytań
                $sql = "SELECT * FROM users WHERE email=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $user = $result->fetch_assoc();
                    if (password_verify($password, $user['password'])) {
                        $_SESSION['logged_in'] = true;
                        $_SESSION['user_id'] = $user['id'];
                        session_regenerate_id();
                        header('Location: ../pages/mainpage.php');
                        exit();
                    } else {
                        echo 'Błędne dane logowania - spróbuj ponownie.';
                    }
                } else {
                    echo 'Błędne dane logowania - spróbuj ponownie.';
                }
                $stmt->close();
                $conn->close();
            }
        }
    }
?>