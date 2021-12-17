<?php
require_once 'config.php';
ini_set('error_reporting', E_ALL);

session_start();
//var_dump($_SESSION);

if(isset($_REQUEST['login_btn'])){

    if (isset($_POST['logout'])){
      session_destroy();
      header('location:index.php');
    }

    
  $_login = filter_var($_REQUEST['login'],FILTER_SANITIZE_STRING);
  $_password = strip_tags($_REQUEST['password']);
  

  if(empty($_login)){
    $errorMsg[] = 'Veuillez entrer votre login';
  }
  if(empty($_password)){
    $errorMsg[] = 'Veuillez entrer votre password';
  }

  else{
    
    $select_stmt = $db->prepare("SELECT * FROM utilisateurs WHERE login = :login LIMIT 1");
    $select_stmt->execute([':login' => $_login]);
    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

    if($select_stmt->rowCount() == true){
      if(password_verify($_password,$row['password'])){
        $_SESSION['user'] = $row;
        header('location:index.php');
      
      }
      else{
      
      $errorMsg[] = 'Login ou password incorrect(s)';
      }
    }
  }
}


?>

<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
	<style>
        body{ 
            font: 14px sans-serif;
            background-color: darkgrey;
            font-family: monospace; 
}

        .logo{
            float: left;
            color: white;
            padding: 6px;
            text-decoration: none;
            font-size: 14px;
            line-height: 22px;
            font-family: monospace;
            cursor: pointer;
}
        
    </style>
    <title>Login</title>
</head>
<body>
<div class="header">
    <a class="logo" href="index.php">Stratomaster</a>
	<div class="container">
		
    <?php
    
    if(isset($_REQUEST['msg'])){
      echo "<p class='alert alert-danger'>".$_REQUEST['msg']."</p>";
    }
    if(isset($errorMsg)){
      foreach($errorMsg as $loginError ){
        echo "<p class='alert alert-danger'>".$loginError."</p>";
      }
      
    }
    ?>
    
    <form action="connexion.php" method="post">
      <div class="mb-3">
          <label for="login" class="form-label">Login</label>
          <input type="text" name="login" class="form-control" placeholder="">
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" name="password" class="form-control" placeholder="">
        </div>
			<button type="submit" name="login_btn" class="btn btn-primary">Login</button>
			<button type="submit" name="logout" class="btn btn-danger">Logout</button>
		</form>
    Vous ne possédez pas de compte ? <a class="inscription" href="inscription.php">Enregistrez-vous ici !</a>
	</div>
</body>
</html>