<?php
require_once "config.php";
ini_set('error_reporting', E_ALL);

session_start();
/*var_dump($_SESSION);*/
if(isset($_POST['profil_btn'])){
    $_login = $_POST['login'];
    $_password = $_POST['password'];
    $_oldlogin = $_SESSION['user']['login'];

    if(empty($_login)){
        $errorMsg[] = 'Veuillez entrer votre login';
      }
      if(empty($_password)){
        $errorMsg[] = 'Veuillez entrer votre password';
      }

    if(empty($_POST['login'])){
        $_login = $_SESSION['user']['login'];
    }

    if(empty($_POST['password'])){
        $_password = $_SESSION['user']['password'];
}
else{
    $hashed_password = password_hash($_password, PASSWORD_DEFAULT);
    $insert_stmt = $db->prepare("UPDATE utilisateurs SET login = :login, password = :password WHERE login = :oldlogin");
    $insert_stmt->bindValue(':login', $_login, PDO::PARAM_STR);
    $insert_stmt->bindValue(':password',$hashed_password, PDO::PARAM_STR);
    $insert_stmt->bindValue(':oldlogin', $_oldlogin, PDO::PARAM_STR);
    $insert_stmt->execute();
    

    $stm1 = $db->prepare("SELECT * FROM utilisateurs WHERE login = :login");
    $stm1->bindValue(':login', $_login, PDO::PARAM_STR);
    $stm1->execute();
    $var = $stm1->fetch(PDO::FETCH_ASSOC);
    header("location: index.php");
    

    if(isset($var)){
    $_SESSION['user'] = $var;
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
        main{
            display:flex;
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
        h1{
            text-align:center;
}
        
    </style>
        <title>Profil</title>
</head>
    
    <body>
<div class="header">
    <a class="logo" href="index.php">Stratomaster</a>
    <h1>Modifier le profil utilisateur</h1>
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
		    <form action="profil.php" method="post">
                <div class="mb-3">
        
                <label for="login" class="form-label">Nouveau login</label>
				<input type="text" name="login" class="form-control" placeholder="<?php if(isset($_SESSION['user']['login'])){
                                                                                        echo $_SESSION['user']['login'];} ?>">
			    </div>
			
                <div class="mb-3">     

                <label for="password" class="form-label">Nouveau password</label>
				<input type="password" name="password" class="form-control" placeholder="">
				</div>
                <button type="submit" name="profil_btn" class="btn btn-primary">Enregistrer</button>
            </form>
	    </div>
    </body>
</html>