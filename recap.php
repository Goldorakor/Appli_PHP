

<?php 
    // recap.php devra nous permettre d'afficher de manière organisée et exhaustive la liste des produits présents en session. Elle doit également présenter le total de l'ensemble de ceux-ci.
    session_start();
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    
    <link rel="stylesheet" href="css/style.css">
    <title>Récapitulatif des produits</title>
</head>
<body>
    <div id="wrapper">

        <nav>
            <ul class="navbar" id="navbar">
                <li class="menu">
                    <a href="index.php">Ajouter un produit</a>
                </li>
            </ul>   
        </nav>
        
        <main class='affichageProduits'>
            <h1>Liste de mes produits</h1>
            
            <div id="tableau">
                <?php 
                
                //var_dump($_SESSION);


                // condition qui vérifie que la clé "products" du tableau de session $_SESSION n'existe pas avec  !isset() ou que cette clé existe mais ne contient aucune donnée : empty()
                if ( !isset($_SESSION['products']) || empty($_SESSION['products']) ) {


                    // on prévient l'utilisateur qu'aucun produit n'existe en session dans les deux cas précédents.
                    echo "<p>Aucun produit en session.</p>";
                }

                // Il ne nous reste plus qu'à afficher le contenu de $_SESSION['products'] dans la partie else de notre condition.
                else {
                    echo "<table class='table table-striped' id='tatata'>",
                        "<thead>",
                            "<tr>",
                                "<th>#</th>",
                                "<th>Nom</th>",
                                "<th>Prix</th>",
                                "<th></th>", // on rajoute la colonne pour les moins
                                "<th>Quantité</th>",
                                "<th></th>", // on rajoute la colonne pour les plus
                                "<th>Total</th>",
                                "<th></th>", // on rajoute une colonne pour les icones poubelles
                            "</tr>",
                        "</thead>",
                        "<tbody>";

                    // avant notre boucle, on initialise une nouvelle variable $totalGeneral à zéro.
                    $totalGeneral = 0;

                    foreach($_SESSION['products'] as $indice => $product) {


                        // on utilise nos variables à l'intérieur de la boucle foreach() et on affiche chaque produit comme ceci :
                        echo "<tr>",
                            "<td>".$indice."</td>",
                            "<td>".$product['name']."</td>",
                            "<td>".number_format($product['price'], 2, ",", "&nbsp;")."&nbsp;€</td>",
                            "<td><a class='btn rouge' href='traitement.php?action=down-qtt&id=$indice'><i class='fa-solid fa-minus'></i></a></td>",
                            "<td>".$product['qtt']."</td>",
                            "<td><a class='btn vert' href='traitement.php?action=up-qtt&id=$indice'><i class='fa-solid fa-plus'></i></a></td>",
                            "<td>".number_format($product['total'], 2, ",", "&nbsp;")."&nbsp;€</td>",
                            "<td><a class='btn orange' href='traitement.php?action=delete&id=$indice'><i class='fa-solid fa-trash'></i></a></td>",
                        "</tr>";


                        /* indications utiles : number_format(
                            variable à modifier, 
                            nombre de décimales souhaité, 
                            caractère séparateur décimal,
                            caractère séparateur de milliers5
                        );
                        */

                        // à chaque passage de boucle, on ajoute le total d'un produit à totalGeneral
                        $totalGeneral += $product['total'];

                    }

                    // on initialise une variable result pour obtenir les qtés totales de produits 
                    

                    echo "<tr>",
                        "<td colspan=4><span id='ta01'>Total Général :</span></td>"; // cellule fusionnée de 4 cellules
                        
                        
                    $result = 0;  
                    foreach($_SESSION['products'] as $index => $product){
                        $result += $product['qtt'];
                    } 

                    echo "<td colspan=2><span id='ta02'>$result articles</span></td>",
                        "<td colspan=2><span id='ta03'>".number_format($totalGeneral, 2, ",", "&nbsp;")."&nbsp;€</span></td>",
                    "</tr>",
                    "</tbody>",
                    "</table>";
                }

                // Les virgules , sont utilisées pour séparer les chaînes de caractères, ce qui est une façon de concaténer plusieurs chaînes sur plusieurs lignes.
                // En PHP : Les virgules peuvent être utilisées dans une instruction echo pour séparer plusieurs chaînes de caractères. Cela permet de rendre le code plus lisible, surtout lorsque plusieurs lignes d'HTML sont générées.

                ?>

                    
                
            </div>


            
            <div class='vidage'>
                <div class='vid'>
                    <?php
                    
                    if(!isset($_SESSION['products']) || empty($_SESSION['products'])){
                        echo"<p id='vid1'>Panier vide</p>";
                    } else {
                        // href="traitement.php?action=clear" : l'attribut href définit la destination du lien. Ici, il pointe vers traitement.php avec un paramètre de requête action=clear ajouté dans l'URL. Cela signifie que lorsque l'utilisateur clique sur le lien, il est redirigé vers traitement.php avec l'action "clear".
                        echo "<a class='soumis' href='traitement.php?action=clear'>Vider le panier</a>";
                        
                    }

                    ?>
                </div>

                <div class='vide'>
                    <?php
                            
                    if(!isset($_SESSION['message']) || empty($_SESSION['message'])){
                        echo "<p id='vid2'></p>";
                    } else {
                        echo $_SESSION['message']; 
                        unset($_SESSION['message']); 
                    
                     }
            
                    ?>
                </div>
                

                
                </div>

        </main>
    </div>

</body>
</html>


