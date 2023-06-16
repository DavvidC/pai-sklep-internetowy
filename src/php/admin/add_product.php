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

    $sql = "INSERT INTO products (name, price, description, quantity) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdsi", $name, $price, $description, $quantity);

    if ($stmt->execute()) {
        echo "Produkt został dodany do bazy danych.";
    } else {
        echo "Błąd podczas dodawania produktu: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
?>