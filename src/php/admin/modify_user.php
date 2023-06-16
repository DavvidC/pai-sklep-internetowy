<?php
    $host = 'localhost';
    $user = 'root';
    $password_db = '';
    $db_name = 'app-db';

    $conn = mysqli_connect($host, $user, $password_db, $db_name);

    if ($conn->connect_error) {
        die("Nie udało się połączyć z bazą danych: " . $conn->connect_error);
    }

    $id = $_POST['id'];
    $imie = $_POST['firstname'];
    $nazwisko = $_POST['surname'];
    $email = $_POST['email'];
    $adres = $_POST['delivery_address'];

    $sql = "UPDATE users SET firstname=?, surname=?, email=?, delivery_address=? WHERE user_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $imie, $nazwisko, $email, $adres, $id);

    if ($stmt->execute()) {
        echo "Dane użytkownika zostały zaktualizowane.";
    } else {
        echo "Wystąpił błąd podczas aktualizacji danych użytkownika: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
?>