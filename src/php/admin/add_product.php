<?php
    $host = 'localhost';
    $user = 'root';
    $password_db = '';
    $db_name = 'app-db';
    
    $conn = mysqli_connect($host, $user, $password_db, $db_name);

    if ($conn->connect_error) {
        die("Połączenie nieudane: " . $conn->connect_error);
    }

    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];

    $sql = "INSERT INTO products (name, price, description, quantity) VALUES ('$name', $price, '$description', $quantity)";
    if ($conn->query($sql) === TRUE) {
        print "Produkt został dodany do bazy danych.";
    } else {
        print "Błąd podczas dodawania produktu: " . $conn->error;
    }

    $conn->close();
?>
