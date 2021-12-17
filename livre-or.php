<?php
require_once "config.php";
ini_set('error_reporting', E_ALL);
session_start();


$select_stmt = $db->prepare("SELECT login, commentaire, date FROM utilisateurs INNER JOIN commentaires WHERE utilisateurs.id = commentaires.id_utilisateur");
$select_stmt-> execute();
$row = $select_stmt->fetchAll(PDO::FETCH_ASSOC);
//var_dump($row);

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
        .wrapper{ 
            width: 360px; padding: 20px; 
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
        .commentaire{
            float:right;
}
        
    </style>
    <title>Livre d'or</title>
</head>
    <body>
        <div class="header">
            <a class="logo" href="index.php">Stratomaster</a>
            <form action="livre-or.php" method="post">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">Commentaire</th>
                  <th scope="col">Utilisateur</th>
                  <th scope="col">Date de publication</th>
                 
                  
                </tr>
              </thead>
              <tbody>
              <a class="commentaire" href="commentaire.php">Laissez un commentaire !</a>
           
<?php
    foreach ($row as $key => $values){
        echo "<tr>";
        foreach ($values as $key => $value){
        echo "<td>" . $value . "</td>";
}
        echo "</tr>";
}
?>
                
              
		    </form>
	    </div>
    </body>
</html>