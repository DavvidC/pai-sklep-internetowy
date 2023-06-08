<?php
// Kod PHP do obsługi zapytań i pobierania danych z bazy danych

// Funkcja do pobrania wszystkich użytkowników
function pobierzWszystkichUzytkownikow() {
  // Implementacja pobierania wszystkich użytkowników z bazy danych
  // ...
  // Przykładowa implementacja
  $uzytkownicy = array(
    array('id' => 1, 'imie' => 'Jan', 'nazwisko' => 'Kowalski'),
    array('id' => 2, 'imie' => 'Anna', 'nazwisko' => 'Nowak'),
    array('id' => 3, 'imie' => 'Adam', 'nazwisko' => 'Nowicki')
  );

  return $uzytkownicy;
}

// Funkcja do pobrania pojedynczego użytkownika na podstawie ID
function pobierzUzytkownika($id) {
  // Implementacja pobierania pojedynczego użytkownika z bazy danych na podstawie ID
  // ...
  // Przykładowa implementacja
  $uzytkownik = array('id' => $id, 'imie' => 'Jan', 'nazwisko' => 'Kowalski');

  return $uzytkownik;
}

// Obsługa zapytania AJAX dla wyświetlania wszystkich użytkowników
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['pokazWszystkich'])) {
  $uzytkownicy = pobierzWszystkichUzytkownikow();
  echo json_encode($uzytkownicy);
  exit;
}

// Obsługa zapytania AJAX dla wyświetlania pojedynczego użytkownika
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['pokazUzytkownika'])) {
  $idUzytkownika = $_GET['idUzytkownika'];
  $uzytkownik = pobierzUzytkownika($idUzytkownika);
  echo json_encode($uzytkownik);
  exit;
}
?>
