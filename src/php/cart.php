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

    // Funkcja do sprawdzania dostępności produktu
    function isProductAvailable($conn, $product_id) {
        $sql = "SELECT quantity FROM products WHERE product_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $product_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            return $row['quantity'] > 0;
        }

        return false;
    }

    // Obsługa dodawania przedmiotu do koszyka
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id']) && isset($_POST['action']) && $_POST['action'] === 'add') {
        $product_id = $_POST['product_id'];

        // Sprawdzenie dostępności produktu
        if (isProductAvailable($conn, $product_id)) {
            // Dodanie produktu do koszyka w sesji
            $sql = "SELECT * FROM products WHERE product_id = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "s", $product_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);

                $product = array(
                    'product_id' => $row['product_id'],
                    'name' => $row['name'],
                    'price' => $row['price'],
                    'quantity' => $row['quantity']
                );

                $_SESSION['cart'][] = $product;
            }
        } else {
            echo "Przepraszamy, ten produkt jest niedostępny.";
        }
    }

    // Obsługa usuwania przedmiotu z koszyka
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id']) && isset($_POST['action']) && $_POST['action'] === 'remove') {
        $product_id = $_POST['product_id'];

        // Znalezienie indeksu produktu w koszyku
        $product_index = -1;
        foreach ($_SESSION['cart'] as $index => $product) {
            if ($product['product_id'] === $product_id) {
                $product_index = $index;
                break;
            }
        }

        // Usunięcie produktu z koszyka
        if ($product_index !== -1) {
            unset($_SESSION['cart'][$product_index]);
            $_SESSION['cart'] = array_values($_SESSION['cart']);
        }
    }

    // Zamykanie połączenia z bazą danych
    mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koszyk</title>
</head>
<body>
    <h1>Koszyk</h1>

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
                // Wyświetlanie produktów w koszyku
                foreach ($_SESSION['cart'] as $product) {
                    // Sprawdzenie czy produkt ma być usunięty
                    if (isset($_POST['action']) && $_POST['action'] === 'remove' && $_POST['product_id'] === $product['product_id']) {
                        continue; // Przejdź do następnego produktu bez wyświetlania aktualnego
                    }

                    echo "<tr>";
                    echo "<td>" . $product['name'] . "</td>";
                    echo "<td>" . $product['price'] . "</td>";
                    echo "<td>" . $product['quantity'] . "</td>";
                    echo "<td>";
                    echo "<form action=\"cart.php\" method=\"POST\">";
                    echo "<input type=\"hidden\" name=\"product_id\" value=\"" . $product['product_id'] . "\">";
                    echo "<input type=\"hidden\" name=\"action\" value=\"remove\">";
                    echo "<input type=\"submit\" value=\"Usuń\">";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
            ?>
        </tbody>
    </table>

    <br>

    <a href="../pages/mainpage.php">Powrót do strony głównej</a>
</body>
</html>