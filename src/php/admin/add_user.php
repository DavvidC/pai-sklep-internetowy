<?php
    $host = 'localhost';
    $user = 'root';
    $password_db = '';
    $db_name = 'app-db';

    $conn = mysqli_connect($host, $user, $password_db, $db_name);

    if ($conn->connect_error) {
        die("Nie udało się połączyć z bazą danych: " . $conn->connect_error);
    }

    $firstname = $_POST['firstname'];
    $surname = $_POST['surname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $delivery_address = $_POST['delivery_address'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (firstname, surname, username, password, email, delivery_address) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $firstname, $surname, $username, $hashed_password, $email, $delivery_address);

    if ($stmt->execute()) {
        echo "Użytkownik został dodany do tabeli users.";
    } else {
        echo "Błąd podczas dodawania użytkownika: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
?>