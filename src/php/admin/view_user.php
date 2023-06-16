<?php
    $host = 'localhost';
    $user = 'root';
    $password_db = '';
    $db_name = 'app-db';

    $conn = mysqli_connect($host, $user, $password_db, $db_name);

    if ($conn->connect_error) {
        die("Połączenie nieudane: " . $conn->connect_error);
    }

    $userId = mysqli_real_escape_string($conn, $_GET['user_id']);

    if (!is_numeric($userId)) {
        echo "ID użytkownika powinno być liczbą.";
        exit;
    }

    $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo "<p><b>ID: </b>" . $row["user_id"] . "</p>";
        echo "<p><b>Email: </b>" . ($row["email"] ? $row["email"] : "brak") . "</p>";
        echo "<p><b>Username: </b>" . ($row["username"] ? $row["username"] : "brak") . "</p>";
        echo "<p><b>Imię: </b>" . ($row["firstname"] ? $row["firstname"] : "brak") . "</p>";
        echo "<p><b>Nazwisko: </b>" . ($row["surname"] ? $row["surname"] : "brak") . "</p>";
        echo "<p><b>Adres dostawy: </b>" . ($row["delivery_address"] ? $row["delivery_address"] : "brak") . "</p>";
        echo "<hr>";
    } else {
        echo "Nie znaleziono użytkownika o podanym ID.";
    }

    $stmt->close();
?>