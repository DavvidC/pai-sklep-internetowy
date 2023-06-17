<?php

    session_start();

    // Sprawdzenie czy $_SESSION['cart'] istnieje, jeśli nie to utwórz pustą tablicę
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    $host = 'localhost';
    $user = 'root';
    $password_db = '';
    $db_name = 'app-db';

    $conn = mysqli_connect($host, $user, $password_db, $db_name);

    // Sprawdzenie połączenia
    if (!$conn) {
        die("Błąd połączenia: " . mysqli_connect_error());
    }

?>

<!DOCTYPE html>
<html lang="pl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
  <title>Zamówienie - Sklep internetowy</title>
  <link rel="stylesheet" type="text/css" href="../assets/css/checkout.css">
</head>

<body>
  <header>
    <a href="../pages/mainpage.php">
        <h1>Sklep internetowy</h1>
    </a>
  </header>
  <div></div>
  <main>
    <section id="order-summary">
      <h2>Twoje zamówienie</h2>
      <ul id="product-list">
        <?php
            foreach ($_SESSION['cart'] as $product) {
                echo '<li>';
                echo "<div class='product-item'>";
                echo "<div class='product-name'>" . $product['name'] . "</div>";
                echo "<div class='product-price-quantity'>" . $product['price'] . " PLN " . "x " . $product['quantity'] . "</div>";
                echo '</li>';
            }
        ?>
      </ul>
    </section>
    <form action="process_order.php" method="POST">
      <fieldset>
        <legend>Dane do wysyłki</legend>
        <div>
          <label for="name">Imię:</label>
          <input type="text" id="name" name="name" required>
        </div>
        <div>
          <label for="email">Email:</label>
          <input type="email" id="email" name="email" required>
        </div>
        <div>
          <label for="address">Adres:</label>
          <input type="text" id="address" name="address" required>
        </div>
        <!-- Add more fields for billing information if needed -->
      </fieldset>

      <fieldset>
        <legend>Płatność kartą kredytową</legend>
        <div>
          <label for="card">Numer karty:</label>
          <input type="text" id="card" name="card" required>
        </div>
        <div>
          <label for="expiry">Data ważności:</label>
          <input type="text" id="expiry" name="expiry" required>
        </div>
        <div>
          <label for="cvv">CVV:</label>
          <input type="text" id="cvv" name="cvv" required>
        </div>
        <!-- Add more fields for payment information if needed -->
      </fieldset>

      <button type="submit">Złóż zamówienie</button>
    </form>
  </main>
</body>

</html>