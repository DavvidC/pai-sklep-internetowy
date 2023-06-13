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

    $sql = "UPDATE users SET firstname='$imie', surname='$nazwisko', email='$email', delivery_address='$adres' WHERE user_id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Dane użytkownika zostały zaktualizowane.";
    } else {
        echo "Wystąpił błąd podczas aktualizacji danych użytkownika: " . $conn->error;
    }

    $conn->close();
?>