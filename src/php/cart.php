<!DOCTYPE html>
<html>
<head>
    <title>Koszyk</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/cart.css">
</head>
<body>
    <h1>Koszyk</h1>
    <table>
        <thead>
            <tr>
                <th>Produkt</th>
                <th>Cena</th>
                <th>Ilość</th>
                <th>Usuń</th>
            </tr>
        </thead>
        <tbody>
            <?php
                // Pobranie danych o produktach z sesji lub bazy danych
                $products = $_SESSION['user_id']; // Załóżmy, że dane o produktach są przechowywane w sesji

                // Wyświetlanie produktów w koszyku
                foreach ($products as $product) {
                    echo "<tr>";
                    echo "<td>" . $product['name'] . "</td>";
                    echo "<td>" . $product['price'] . "</td>";
                    echo "<td>" . $product['quantity'] . "</td>";
                    echo "<td><a href='remove_from_cart.php?id=" . $product['id'] . "'>Usuń</a></td>";
                    echo "</tr>";
                }
            ?>
        </tbody>
    </table>
    <a href="checkout.php">Przejdź do kasy</a>
</body>
</html>
