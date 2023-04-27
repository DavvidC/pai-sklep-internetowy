<?php require_once("/templates/header-http.php"); ?>
    <h1>Login Page</h1>
    <form method="POST" action="../php/process_login.php">
      <label for="email">Email:</label>
      <input type="text" id="email" name="email" required />
      <br />
      <label for="username">Username:</label>
      <input type="text" id="username" name="username" required />
      <br />
      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required />
      <br />
      <div class="buttonRegister"> <!-- zmieniam nazwe z 'buttons' bo buttons uzywam do przekierowania na inne page pozdro 600 -->
        <input type="submit" value="Sign in" />
      </div>
    </form>
  </body>
</html>