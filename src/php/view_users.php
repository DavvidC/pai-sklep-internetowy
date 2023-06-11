<?php
// Kod PHP do obsługi zapytań i pobierania danych z bazy danych

// Funkcja do pobrania wszystkich użytkowników
function getAllUsers() {
  // Implementacja pobierania wszystkich użytkowników z bazy danych
  // ...
  // Przykładowa implementacja
  $users = array(
    array('id' => 1, 'imie' => 'Jan', 'nazwisko' => 'Kowalski'),
    array('id' => 2, 'imie' => 'Anna', 'nazwisko' => 'Nowak'),
    array('id' => 3, 'imie' => 'Adam', 'nazwisko' => 'Nowicki')
  );

  return $users;
}

// Funkcja do pobrania pojedynczego użytkownika na podstawie ID
function getUser($id) {
  // Implementacja pobierania pojedynczego użytkownika z bazy danych na podstawie ID
  // ...
  // Przykładowa implementacja
  $user = array('id' => $id, 'imie' => 'Jan', 'nazwisko' => 'Kowalski');

  return $user;
}

// Obsługa zapytania AJAX dla wyświetlania wszystkich użytkowników
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['showAllUsers'])) {
  $users = getAllUsers();
  echo json_encode($users);
  exit;
}

// Obsługa zapytania AJAX dla wyświetlania pojedynczego użytkownika
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['showUser'])) {
  $userId = $_GET['userId'];
  $user = getUser($userId);
  echo json_encode($user);
  exit;
}
?>
