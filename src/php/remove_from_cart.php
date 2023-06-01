<?php
    session_start();

    // Sprawdź, czy parametr ID został przekazany w żądaniu
    if(isset($_GET['id'])) {
        $productId = $_GET['id'];

        // Pobierz dane o produktach z sesji
        $products = $_SESSION['cart'];

        // Znajdź indeks produktu, który ma zostać usunięty
        $productIndex = -1;
        foreach ($products as $index => $product) {
            if ($product['id'] == $productId) {
                $productIndex = $index;
                break;
            }
        }

        // Jeśli znaleziono produkt, usuń go z koszyka
        if ($productIndex !== -1) {
            unset($products[$productIndex]);
            $_SESSION['cart'] = $products;
        }
    }

    // Przekieruj użytkownika z powrotem do koszyka
    header('Location: cart.php');
    exit();
?>
