<?php
  $host = 'localhost';
  $user = 'root';
  $password_db = '';
  $db_name = 'app-db';

  $conn = mysqli_connect($host, $user, $password_db, $db_name);

  if ($conn->connect_error) {
      die("Połączenie nieudane: " . $conn->connect_error);
  }

  $sql = "SELECT * FROM users";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          $userId = $row["user_id"];
          $email = $row["email"];
          $username = $row["username"];
          $firstname = $row["firstname"];
          $surname = $row["surname"];
          $deliveryAddress = $row["delivery_address"];

          echo "<p><b>ID: </b>" . $userId . "</p>";
          echo "<p><b>Email: </b>" . ($email ? $email : "brak") . "</p>";
          echo "<p><b>Username: </b>" . ($username ? $username : "brak") . "</p>";
          echo "<p><b>Imię: </b>" . ($firstname ? $firstname : "brak") . "</p>";
          echo "<p><b>Nazwisko: </b>" . ($surname ? $surname : "brak") . "</p>";
          echo "<p><b>Adres dostawy: </b>" . ($deliveryAddress ? $deliveryAddress : "brak") . "</p>";
          echo "<hr>";
      }
  } else {
      echo "Brak użytkowników w bazie danych.";
  }

  $stmt->close();
  $conn->close();
?>