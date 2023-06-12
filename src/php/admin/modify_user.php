<?php
// Połączenie z bazą danych
$servername = "nazwa_serwera";
$username = "nazwa_uzytkownika";
$password = "haslo";
$dbname = "nazwa_bazy_danych";

$conn = new mysqli($servername, $username, $password, $dbname);

// Sprawdzenie połączenia
if ($conn->connect_error) {
    die("Nie udało się połączyć z bazą danych: " . $conn->connect_error);
}

// Pobranie danych z formularza
$id = $_POST['id'];
$imie = $_POST['imie'];
$nazwisko = $_POST['nazwisko'];
$email = $_POST['email'];
$adres = $_POST['adres'];

// Aktualizacja danych użytkownika w bazie danych
$sql = "UPDATE uzytkownicy SET imie='$imie', nazwisko='$nazwisko', email='$email', adres='$adres' WHERE id='$id'";

if ($conn->query($sql) === TRUE) {
    echo "Dane użytkownika zostały zaktualizowane.";
} else {
    echo "Wystąpił błąd podczas aktualizacji danych użytkownika: " . $conn->error;
}

// Zamknięcie połączenia z bazą danych
$conn->close();
?>
