<?php
// Funkcja do dodawania użytkownika do bazy danych
function dodajUzytkownika($imie, $nazwisko, $email, $adres) {
  // Implementacja dodawania użytkownika do bazy danych
  // ...
  // Przykładowa implementacja
  // Połączenie z bazą danych
  $conn = new mysqli("localhost", "username", "password", "database_name");
  if ($conn->connect_error) {
    die("Błąd połączenia z bazą danych: " . $conn->connect_error);
  }

  // Przygotowanie i wykonanie zapytania SQL
  $sql = "INSERT INTO uzytkownicy (imie, nazwisko, email, adres) VALUES ('$imie', '$nazwisko', '$email', '$adres')";
  if ($conn->query($sql) === TRUE) {
    echo "Użytkownik został dodany.";
  } else {
    echo "Błąd podczas dodawania użytkownika: " . $conn->error;
  }

  $conn->close();
}

// Funkcja do usuwania użytkownika z bazy danych na podstawie ID
function usunUzytkownika($id) {
  // Implementacja usuwania użytkownika z bazy danych na podstawie ID
  // ...
  // Przykładowa implementacja
  // Połączenie z bazą danych
  $conn = new mysqli("localhost", "username", "password", "database_name");
  if ($conn->connect_error) {
    die("Błąd połączenia z bazą danych: " . $conn->connect_error);
  }

  // Przygotowanie i wykonanie zapytania SQL
  $sql = "DELETE FROM uzytkownicy WHERE id = $id";
  if ($conn->query($sql) === TRUE) {
    echo "Użytkownik został usunięty.";
  } else {
    echo "Błąd podczas usuwania użytkownika: " . $conn->error;
  }

  $conn->close();
}

// Obsługa formularza dodawania użytkownika
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['dodajUzytkownika'])) {
  $imie = $_POST['imie'];
  $nazwisko = $_POST['nazwisko'];
  $email = $_POST['email'];
  $adres = $_POST['adres'];

  dodajUzytkownika($imie, $nazwisko, $email, $adres);
}

// Obsługa formularza usuwania użytkownika
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['usunUzytkownika'])) {
  $id = $_POST['idUzytkownika'];

  usunUzytkownika($id);
}
?>
