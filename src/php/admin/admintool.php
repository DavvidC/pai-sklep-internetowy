<!DOCTYPE html>
<html lang="pl-PL">

<head>
  <title>Panel Administratora</title>
  <meta charset="UTF-8">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="../../assets/css/admintool.css">
</head>

<body>
  <header>
    <h1>Panel Administratora</h1>
  </header>
  <main>

    <section>
      <h2>Dodaj produkt</h2>
      <form action="add_product.php" method="POST">
        <div>
          <label for="name">Nazwa przedmiotu:</label>
          <input type="text" id="name" name="name" required>
        </div>
        <div>
          <label for="price">Cena:</label>
          <input type="number" id="price" name="price" step="0.01" required>
        </div>
        <div>
          <label for="description">Opis:</label>
          <textarea id="description" name="description" required></textarea>
        </div>
        <div>
          <label for="quantity">Ilość:</label>
          <input type="text" id="quantity" name="quantity" required>
        </div>
        <button type="submit">Dodaj produkt</button>
      </form>
    </section>

    <section>
      <h2>Usuń Produkt</h2>
      <div class="dropdown">
        <button class="dropdown-button">Wybierz opcję do usunięcia</button>
        <ul class="dropdown-menu">
          <?php
          $host = 'localhost';
          $user = 'root';
          $password_db = '';
          $db_name = 'app-db';

          $conn = mysqli_connect($host, $user, $password_db, $db_name);

          if ($conn->connect_error) {
            die("Połączenie nieudane: " . $conn->connect_error);
          }

          if (isset($_GET['id'])) {
            $productId = $_GET['id'];

            $deleteSql = "DELETE FROM products WHERE product_id = $productId";
            if ($conn->query($deleteSql) === TRUE) {
              echo "Produkt został usunięty z bazy danych.";
            } else {
              echo "Błąd podczas usuwania produktu: " . $conn->error;
            }
          }

          $sql = "SELECT * FROM products";
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              $productId = $row['product_id'];
              $productName = $row['name'];
              echo '<li><a href="?id=' . $productId . '">' . $productName . '</a></li>';
            }
          } else {
            echo 'Brak produktów w bazie danych.';
          }

          $conn->close();
          ?>
        </ul>
      </div>
    </section>

    <hr>

    <section>
      <h2>Dodawanie nowego użytkownika</h2>
      <form action="add_user.php" method="POST">
        <label for="firstname">Imię:</label>
        <input type="text" id="firstname" name="firstname" required>
        </div>
        <div>
          <label for="surname">Nazwisko:</label>
          <input type="text" id="surname" name="surname" required>
        </div>
        <div>
          <label for="username">Nazwa użytkownika:</label>
          <input type="text" id="username" name="username" required>
        </div>
        <div>
          <label for="password">Hasło:</label>
          <input type="text" id="password" name="password" required>
        </div>
        <div>
          <label for="email">Adres email:</label>
          <input type="email" id="email" name="email" required>
        </div>
        <div>
          <label for="delivery_address">Adres dostawy:</label>
          <input type="text" id="delivery_address" name="delivery_address" required>
        </div>
        <button type="submit">Dodaj użytkownika</button>
      </form>
    </section>

    <section>
      <!--W powyższym kodzie dodaliśmy sekcję "Modyfikuj użytkownika" zawierającą formularz. 
            Formularz posiada pola, w których można wprowadzić nowe dane użytkownika, takie jak "Imię", "Nazwisko", "Adres email" i "Adres dostawy".
            Przy użyciu atrybutu required zapewniamy, że pola są wymagane przed wysłaniem formularza.
            W pliku PHP "modyfikuj_uzytkownika.php" musisz obsłużyć przesłane dane z formularza i zaktualizować dane użytkownika w bazie danych na podstawie przekazanego identyfikatora użytkownika. 
            W tym skrypcie PHP należy uwzględnić bezpieczeństwo danych, takie jak ochrona przed atakami typu SQL Injection.-->
      <h2>Modyfikuj użytkownika</h2>
      <form action="modify_user.php" method="POST">
        <div>
          <label for="id">ID użytkownika:</label>
          <input type="text" id="id" name="id" required>
        </div>
        <div>
          <label for="firstname">Imię:</label>
          <input type="text" id="firstname" name="firstname" required>
        </div>
        <div>
          <label for="surname">Nazwisko:</label>
          <input type="text" id="surname" name="surname" required>
        </div>
        <div>
          <label for="email">Adres email:</label>
          <input type="email" id="email" name="email" required>
        </div>
        <div>
          <label for="delivery_address">Adres dostawy:</label>
          <input type="text" id="delivery_address" name="delivery_address" required>
        </div>
        <button type="submit">Zapisz zmiany</button>
      </form>
    </section>
    <section>
      <h2>Usuń użytkownika</h2>
      <div class="dropdown">
        <button class="dropdown-button">Wybierz użytkownika do usunięcia</button>
        <ul class="dropdown-menu">
          <?php
              $host = 'localhost';
              $user = 'root';
              $password_db = '';
              $db_name = 'app-db';

              $conn = mysqli_connect($host, $user, $password_db, $db_name);

              if ($conn->connect_error) {
                die("Połączenie nieudane: " . $conn->connect_error);
              }

              if (isset($_GET['user_id'])) {
                $userId = $_GET['user_id'];

                $deleteSql = "DELETE FROM users WHERE user_id = $userId";
                if ($conn->query($deleteSql) === TRUE) {
                  echo "Produkt został usunięty z bazy danych.";
                } else {
                  echo "Błąd podczas usuwania produktu: " . $conn->error;
                }
              }

              $sql = "SELECT * FROM users LIMIT 5;";
              $result = $conn->query($sql);

              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  $userId = $row['user_id'];
                  $username = $row['username'];
                  $email = $row['email'];
                  echo '<li><a href="?id=' . $userId . '">' . $username . ' (' . $email . ')</a></li>';
                }
              } else {
                echo 'Brak użytkowników w bazie danych.';
              }

              $conn->close();
            ?>
        </ul>
      </div>
    </section>
    <hr>
    <section>
      <section>
        <h2>Wyświetlanie wszystkich użytkowników</h2>
        <form action="view_users.php" method="GET">
          <div>
            <button type="submit">Pokaż wszystkich użytkowników</button>
          </div>
        </form>
        <div id="wynikWszystkichUzytkownikow"></div>
      </section>

      <section>
        <h2>Wyświetlanie pojedynczego użytkownika</h2>
        <div>
          <label for="idUzytkownika">ID Użytkownika:</label>
          <input type="text" id="idUzytkownika">
          <button onclick="pokazUzytkownika()">Pokaż użytkownika</button>
        </div>
        <div id="wynikUzytkownika"></div>
      </section>
      <!--TUTAJ MA BYC USUWANIE ZAMÓWIENIA-->
      <!--   <h2>Usuń zamówienie</h2>
        <div class="dropdown">
          <button class="dropdown-button">Wybierz opcję</button>
          <ul class="dropdown-menu">
            <li><a href="#">Opcja 1</a></li>
            <li><a href="#">Opcja 2</a></li>
            <li><a href="#">Opcja 3</a></li>
            <li><a href="#">Opcja 4</a></li>
          </ul>
        </div>
        <button class="remove-button">Usuń</button>
      </section> -->
  </main>
  <footer>
    <p>&copy; 2023 Sklep Internetowy. Wszelkie prawa zastrzeżone.</p>
  </footer>
</body>

</html>