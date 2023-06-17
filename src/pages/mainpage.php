<?php
session_start();

$host = 'localhost';
$user = 'root';
$password_db = '';
$db_name = 'app-db';

$conn = mysqli_connect($host, $user, $password_db, $db_name);

if (!$conn) {
    die("Błąd połączenia: " . mysqli_connect_error());
}

$sql = "SELECT * FROM products";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) === 0) {
    echo "Brak dostępnych produktów.";
} else {
    
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../assets/css/cartstyle.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <title>Strona główna</title>
</head>
<body>
    <header>
        <div class="left">
            <h1>Strona główna</h1>
        </div>
        <div class="right">
            <div class="admin">
                <form action="../php/admin/admintool.php" method="GET">
                    <input type="submit" class="logout-button" value="Panel admina">
                </form>
               <?php
            /* Sprawdzenie, czy użytkownik ma uprawnienia administratora
            if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] === true) {
                echo "<div class='admin'>";
                echo "<form action='../php/admin/admintool.php' method='GET'>";
                echo "<input type='submit' class='logout-button' value='Panel admina'>";
                echo "</form>";
                echo "</div>";
            } */
            ?>
            </div>
            <div class="logout">
                <form action="../php/process_logout.php" method="POST">
                    <input type="submit" class="logout-button" value="Wyloguj się">
                </form>
            </div>
            <div class="cart">
                <form action="../php/cart.php" method="GET">
                    <button type="submit" class="cart-button">
                        <img class="cart-icon" src="../assets/gfx/cart.svg" alt="Cart Icon">
                    </button>
                </form>
            </div>
        </div>
    </header>
    <main>
        <div class="product-grid" id="product-grid">
            <div class="grid-container">
                <?php
                // Wyświetlanie produktów
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='product-item'>";
                    echo "<div class='product-name'>" . $row['name'] . "</div>";
                    echo "<div class='product-price-quantity'>" . $row['price'] . " PLN" . "</div>";
                    echo "<div class='product-add'>";
                    echo "<form action='../php/cart.php' method='POST'>";
                    echo "<input type='hidden' name='product_id' value='" . $row['product_id'] . "'>";
                    echo "<input type='submit' class='add-button' name='add' value='Dodaj do koszyka'>";
                    echo "</form>";
                    echo "</div>";
                    echo "</div>";
                }
                ?>
            </div>
        </div>

    </main>
    <footer>
        <p>&copy; 2023 Sklep internetowy</p>
    </footer>
</body>
</html>

<?php
}

mysqli_close($conn);
?>
