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
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id']) && isset($_POST['add'])) {
    $product_id = $_POST['product_id'];

    // Sprawdzenie dostępności produktu
    if (isProductAvailable($conn, $product_id)) {
        // Sprawdzenie czy produkt już istnieje w koszyku
        $product_index = -1;
        foreach ($_SESSION['cart'] as $index => $product) {
            if ($product['product_id'] == $product_id) {
                $product_index = $index;
                break;
            }
        }

        // Dodanie produktu do koszyka
        if ($product_index !== -1) {
            $_SESSION['cart'][$product_index]['quantity'] += 1;
        } else {
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
                    'quantity' => 1
                );

                $_SESSION['cart'][] = $product;
            }
        }
    } else {
        echo "Przepraszamy, ten produkt jest niedostępny.";
    }
}


// Obsługa usuwania przedmiotu z koszyka
if (isset($_POST['remove'])) {
    $product_id = $_POST['product_id'];
    // Znalezienie indeksu produktu w koszyku
    $product_index = -1;
    foreach ($_SESSION['cart'] as $index => $product) {
        if ($product['product_id'] == $product_id) {
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
<html>
<head>
    <title>Koszyk</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/cartstyle.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
</head>
<body>
<header>
    <div class="left">
        <h1>Koszyk</h1>
    </div>
    <div class="right">
        <div class="cart-items" id="cart-items">
            <a href="../pages/mainpage.php">Powrót do strony głównej</a>
        </div>
        <div class="cart">
            <span class="cart-count"><?php echo array_sum(array_column($_SESSION['cart'], 'quantity')); ?></span>
            <img class="cart-icon" src="../assets/gfx/cart.svg" alt="Cart Icon">
        </div>
    </div>
</header>
<main>
    <div class="product-grid" id="product-grid">
        <div class="grid-container">
            <?php
            $totalPrice = 0;
            // Wyświetlanie produktów w koszyku
            foreach ($_SESSION['cart'] as $product) {
                // Sprawdzenie czy produkt ma być usunięty
                if (isset($_POST['action']) && $_POST['action'] === 'remove' && $_POST['product_id'] === $product['product_id']) {
                    continue; // Przejdź do następnego produktu bez wyświetlania aktualnego
                }

                $totalPrice += $product['price'] * $product['quantity'];

                echo "<div class='product-item'>";
                echo "<div class='product-name'>" . $product['name'] . "</div>";
                echo "<div class='product-price-quantity'>" . $product['price'] . " PLN " . "x " . $product['quantity'] . "</div>";
                echo "<div class='product-remove'>";
                echo "<form action=\"cart.php\" method=\"POST\">";
                echo "<input type=\"hidden\" name=\"product_id\" value=\"" . $product['product_id'] . "\">";
                echo "<input type=\"hidden\" name=\"action\" value=\"remove\">";
                echo "<input type=\"submit\" class=\"remove-button\" name=\"remove\" value=\"Usuń\">";
                echo "</form>";
                echo "</div>";
                echo "</div>";
            }
            ?>
        </div>
    </div>
    <div class="cart-total">
        <span>Łącznie: </span>
        <span class="total-amount"><?php echo number_format($totalPrice, 2); ?> PLN</span>
    </div>
</main>
<footer>
    <div class="checkout">
        <a href="../pages/checkout.php">Przejdź do płatności</a>
    </div>
</footer>
</body>
</html>
