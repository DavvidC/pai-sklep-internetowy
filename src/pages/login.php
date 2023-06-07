<!DOCTYPE html>
<html>
  <head>
    <title>Register Page</title>
    <link rel="stylesheet" href="../assets/css/style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
  </head>
  <body>
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