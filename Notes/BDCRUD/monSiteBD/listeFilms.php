<?php

// 1. Créer une connexion à la BD
include "./connexion/db.php";

try {
        $cnx = new PDO(DBDRIVER . ':host=' . DBHOST . ';port=' . DBPORT . ';dbname=' . DBNAME . ';charset=' . DBCHARSET, DBUSER, DBPASS);
} catch (Exception $e) {
        // jamais en production car ça montre des infos
        // sensibles
        echo $e->getMessage();
        
        die();
}
// 2. Créer une requête SQL
$sql = "SELECT * FROM film";

// 3. Lancer la requête (préparation et lancement)
$stmt = $cnx->prepare($sql);
$stmt->execute();


// 4. Obtenir les données dans un array 
$arrayRes = $stmt->fetchAll(PDO::FETCH_ASSOC);

//var_dump ($arrayRes);

// 5. Afficher los données selon nos besoins





foreach ($arrayRes as $film) {

        echo '<div class="card" style="width: 10rem;">';
        
        echo '<a href="./detailFilm.php?id='. $film['id']  .'"><img class="card-img-top" src="./img/'  . $film['image'] .   '" alt="'. $film['titre'] . '"></a>';
        echo '<div class="card-body">';
        
        echo '<h5 class="card-title">'. $film['titre'] . '</h5>';
        echo '<button class="likeButton" id=' . $film['id']. '><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
  <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"/>
</svg></button>';
        echo '</div>';
        
        echo '</div>';
        
        echo "<a href ='./effacerFilm.php?id=" . $film['id']. "'>Effacer</a>&nbsp";
        echo "<a href ='./index.php?p=updateFilm&id=" . $film['id']. "'>Modifier</a>";
}





