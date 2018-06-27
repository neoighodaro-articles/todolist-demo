<?php session_start(); ?>
<?php require_once '../functions.php'; ?>

<?php
 if(!isset($_SESSION['user_id'])) {
   header('location: ../');
 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Todo Home</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <style>
    body {
      background: #EEE;
    }
    .todo__no__space{
      padding-left: 0px;
      padding-right: 0px;
    }
  </style>
</head>
<body>
<nav class="navbar navbar-default">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="home.php">Todo</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

      <ul class="nav navbar-nav navbar-right">
        <li><a href="logout.php"><?php echo $_SESSION['user_id'] ?>, Logout </a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->

</nav>

  <div class="col-md-5 col-md-offset-3" style="background: #FFF;padding: 10px">
    <div class="pull-left">
      <h2>Todo List</h2>
    </div>
    <div class="pull-right">
      <a href="add.php" class="btn btn-info">Add New</a>
    </div>
    <div class="clearfix"></div>

    <?php

      /**
       * Done
       */

       if(isset($_GET['rel']) and $_GET['rel'] == 'done') {
         $status = ($_GET['status'] == '0' ) ? '1' : '0';
         $query = $pdo->prepare('UPDATE todos SET completed = ? WHERE id=?');
         $query->execute([$status, $_GET['id']]);
        //  echo $status.' is here';
       }
      /**
       * delete
       */

      if( isset($_GET['rel']) and $_GET['rel'] =='delete') {
        $query = $pdo->prepare('DELETE FROM todos WHERE id=?');
        $query->execute([$_GET['id']]);
      }
      $user = $_SESSION['user_id'];
      $query = $pdo->prepare('SELECT * FROM todos WHERE user_id=? ORDER BY id DESC');
      $query->execute([$user]);

      if( $query->rowCount() > 0 ):
    ?>
    <ul class="list-group">

     <?php while($fetch = $query->fetch()): ?>
      <li class="list-group-item">
        <div class="col-md-9 todo__no__space">
          <?php if( isset($_GET['rel']) and $_GET['rel'] == 'edit' and $_GET['id'] == $fetch['id']): ?>
            <form method="POST">
              <input type="text" name="title" class="form-control" value="<?=$fetch['title']?>">
              <p></p>
              <button name="btnupdate" class="btn btn-primary btn-sm" type="submit">submit</button>
              <?php if(isset($_POST['btnupdate'])):
                $title = $_POST['title'];
                $sql = $pdo->prepare('UPDATE todos SET title = ? WHERE user_id=? AND id=?');
                $sql->execute([$title, $user, $fetch['id']]);
                header('location: home.php');
              endif ?>
            </form>
          <?php else: ?>
          <?php if( $fetch['completed'] == '1'): ?>
            <b style="text-decoration:line-through"><?=$fetch['title']?></b>
          <?php
              else:
           ?>
            <a href="?rel=more">
              <?php echo $fetch['title'] ?>
            </a>
          <?php endif; ?>
            <p></p>
            <p style="font-size: 12px;"><?php echo $fetch['created_at']?></p>
          <?php endif ?>
        </div>
        <div class="col-md-3">
          <a href="?rel=edit&id=<?=$fetch['id']?>">edit</a> &nbsp;
          <a href="?rel=delete&id=<?=$fetch['id']?>">delete</a>
          <a href="?rel=done&id=<?=$fetch['id']?>&status=<?=$fetch['completed']?>">
          <?php if( $fetch['completed'] == '1'): ?>
             undone
          <?php else: ?>
              done
          <?php endif; ?>
          </a>
        </div>
        <div class="clearfix"></div>
      </li>
      <?php endwhile ?>
    </ul>
    <?php else: ?>
        <p>No Todos Available </p>
   <?php endif ?>
  </div>
</body>
</html>