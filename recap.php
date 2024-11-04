

<?php 
    // recap.php devra nous permettre d'afficher de manière organisée et exhaustive la liste des produits présents en session. Elle doit également présenter le total de l'ensemble de ceux-ci.
    session_start();
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Récapitulatif des produits</title>
</head>
<body>
    <div id="wrapper">

        <nav>
            <ul class="navbar" id="navbar">
                <li class="menu">
                    <a href="index.php">Vers index.php</a>
                </li>
            </ul>   
        </nav>
        
        <main class="affichageProduits">
            <h1>Liste de mes produits</h1>
            
            <div class="tableau">
                <?php 
                
                //var_dump($_SESSION);


                // condition qui vérifie que la clé "products" du tableau de session $_SESSION n'existe pas avec  !isset() ou que cette clé existe mais ne contient aucune donnée : empty()
                if ( !isset($_SESSION['products']) || empty($_SESSION['products']) ) {


                    // on prévient l'utilisateur qu'aucun produit n'existe en session dans les deux cas précédents.
                    echo "<p>Aucun produit en session.</p>";
                }

                // Il ne nous reste plus qu'à afficher le contenu de $_SESSION['products'] dans la partie else de notre condition.
                else {
                    echo "<table class='tableau' border=1>",
                        "<thead>",
                            "<tr>",
                                "<th>#</th>",
                                "<th>Nom</th>",
                                "<th>Prix</th>",
                                "<th>Quantité</th>",
                                "<th>Total</th>",
                            "</tr>",
                        "</thead>",
                        "<tbody>";

                    // avant notre boucle, on initialise une nouvelle variable $toatlGeneral à zéro.
                    $totalGeneral = 0;

                    foreach($_SESSION['products'] as $index => $product) {


                        // on utilise nos variables à l'intérieur de la boucle foreach() et on affiche chaque produit comme ceci :
                        echo "<tr>",
                            "<td>".$index."</td>",
                            "<td>".$product['name']."</td>",
                            "<td>".number_format($product['price'], 2, ",", "&nbsp;")."&nbsp;€</td>",
                            "<td>".$product['qtt']."</td>",
                            "<td>".number_format($product['total'], 2, ",", "&nbsp;")."&nbsp;€</td>",
                        "</tr>";


                        /* indications utiles : number_format(
                            variable à modifier, 
                            nombre de décimales souhaité, 
                            caractère séparateur décimal,
                            caractère séparateur de milliers5
                        );
                        */

                        $totalGeneral += $product['total'];

                    }

                    echo "<tr>",
                        "<td colspan = 4>Total Général : </td>", // cellule fusionnée de 4 cellules
                        "<td><strong>".number_format($totalGeneral, 2, ",", "&nbsp;")."&nbsp;€</strong></td>",
                    "</tr>",
                    "</tbody>",
                    "</table>";
                }

                // Les virgules , sont utilisées pour séparer les chaînes de caractères, ce qui est une façon de concaténer plusieurs chaînes sur plusieurs lignes.
                // En PHP : Les virgules peuvent être utilisées dans une instruction echo pour séparer plusieurs chaînes de caractères. Cela permet de rendre le code plus lisible, surtout lorsque plusieurs lignes d'HTML sont générées.

                ?>

                <div class="compteur">

                    <h4 class="count">
                        Quantité totale de produits :
                        <?php

                        // si le tableau des produits est mal défini (non défini ou NULL) ou si le tableau est vide, on affichera zéro.
                        if(!isset($_SESSION['products']) || empty($_SESSION['products'])) {
                            echo "0";
                        }

                        else {
                            // on initialise la variable à 0
                            $result=0;

                            foreach ($_SESSION['products'] as $index => $product) {
                                // on ajoute la quantité de chaque produit (qui est $product['qtt']) à notre variable $resultat
                                $result += $product['qtt'];
                            }
                            echo $result;
                        }
                        ?>
                    </h4>

                </div>
                
            </div>


            
            <div class="vidage">
                <?php
            
                if(!isset($_SESSION['products']) || empty($_SESSION['products'])){
                    echo"";
                } else {
                    // href="traitement.php?action=clear" : l'attribut href définit la destination du lien. Ici, il pointe vers traitement.php avec un paramètre de requête action=clear ajouté dans l'URL. Cela signifie que lorsque l'utilisateur clique sur le lien, il est redirigé vers traitement.php avec l'action "clear".
                    echo '<a class="clear" href="traitement.php?action=clear">Vider le panier</a>';
                    
                }

                if(!isset($_SESSION['message']) || empty($_SESSION['message'])){
                    echo "";
                } else {
                    echo $_SESSION["message"]; 
                    unset($_SESSION["message"]); 
                    
                }

                ?>
            </div>

        </main>
    </div>

</body>
</html>


