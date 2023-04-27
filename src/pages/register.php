<?php require_once("/templates/header-http.php"); ?>
    <h1>Register Page</h1>
    <form method="POST" action="../php/process_register.php">
      <label for="email">Email:</label>
      <input type="text" id="email" name="email" />
      <br />
      <label for="username">Username:</label>
      <input type="text" id="username" name="username" />
      <br />
      <label for="password">Password:</label>
      <input type="password" id="password" name="password" />
      <br />
      <div class="buttonLogin"> <!-- zmieniam nazwe z 'buttons' bo buttons uzywam do przekierowania na inne page pozdro 600 -->
        <input type="submit" value="Sign up" />
      </div>
    </form>
  </body>
</html>