<?php
session_start();

$host = 'localhost';
$user = 'root';
$password_db = '';
$db_name = 'app-db';

$conn = mysqli_connect($host, $user, $password_db, $db_name);

// Sprawdzenie połączenia
if (!$conn) {
    die("Błąd połączenia: " . mysqli_connect_error());
}

// Pobranie danych o produktach
$sql = "SELECT * FROM products";
$result = mysqli_query($conn, $sql);

// Sprawdzenie, czy zapytanie zwróciło wyniki
if (!$result || mysqli_num_rows($result) === 0) {
    echo "Brak dostępnych produktów.";
} else {
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strona główna</title>
</head>
<body>

    <form action="../php/process_logout.php" method="POST">
        <input type="submit" value="Wyloguj się">
    </form>
    <form action="../php/cart.php" method="GET">
        <input type="submit" value="Przejdź do koszyka">
    </form>

    <table>
        <thead>
            <tr>
                <th>Produkt</th>
                <th>Cena</th>
                <th>Dostępna ilość</th>
                <th>Akcja</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Wyświetlanie produktów
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['price'] . "</td>";
                echo "<td>" . $row['quantity'] . "</td>";
                echo "<td>";
                echo "<form action=\"../php/cart.php\" method=\"POST\">";
                echo "<input type=\"hidden\" name=\"product_id\" value=\"" . $row['product_id'] . "\">";
                echo "<input type=\"submit\" name=\"add\" value=\"Dodaj do koszyka\">";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

</body>
</html>

<?php
}

// Zamykanie połączenia z bazą danych
mysqli_close($conn);
?>