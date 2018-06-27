<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Vanilla Todo App</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <style>
    body {
      background: #EEE;
    }
    .login {
      background: #FFF;
      padding: 10px;
      margin-top: 40px;
    }
  </style>
</head>
<body>
  <div class="rows">
    <div class="col-md-4 col-md-offset-4 login">
      <form method="POST">
        <h1> Login </h1>
        <label>Email Address</label>
        <input type="text" class="form-control" name="email" required>
        <label>Password</label>
        <input type="password" class="form-control" name="pass" required>
        <br>
        <button type="submit" name="btnLogin" class="btn btn-primary">Submit</button>
        <a href="register.php">Create Account</a>
        <?php

          require_once 'functions.php';
          if( isset($_POST['btnLogin'])):
            $email = $_POST['email'];
            $pass = md5($_POST['pass']);
            $query = $pdo->prepare('SELECT * FROM users WHERE email = ? AND password=?');
            $query->execute([$email, $pass]);
            $rows = $query->rowCount();

            if( $rows > 0 ):
              $_SESSION['user_id'] = $email;
              header('location: pages/home.php');
            else: ?>
              <div class="alert alert-danger">
                <b> Invalid Information supplied</b>
              </div>
            <?php endif ?>
        <?php endif ?>
      </form>
    </div>
  </div>
</body>
</html>