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
        <label>Name</label>
        <input type="text" class="form-control" name="name" required>
        <label>Email Address</label>
        <input type="text" class="form-control" name="email" required>
        <label>Password</label>
        <input type="password" class="form-control" name="pass" required>
        <br>
        <button type="submit" name="btnLogin" class="btn btn-primary">Submit</button>
        <a href="./">Login</a>
        <?php

          require_once 'functions.php';
          if( isset($_POST['btnLogin'])):
            $fname = $_POST['name'];
            $email = $_POST['email'];
            $pass = $_POST['pass'];
            $pwd  = md5($pass);
            $query = $pdo->prepare('SELECT * FROM users WHERE email = ? AND password=?');
            $query->execute([$email, $pass]);
            $rows = $query->rowCount();

            if( $rows > 0 ):
          ?>
           <div class="alert alert-danger">
                <b> Invalid Information supplied</b>
              </div>
          <?php else:
              $save = $pdo->query("INSERT INTO users(name, username, email, password) VALUES('{$fname}', '', '{$email}', '{$pwd}')");
              $_SESSION['user_id'] = $email;
              header('location: pages/home.php');
            endif ?>
        <?php endif ?>
      </form>
    </div>
  </div>
</body>
</html>