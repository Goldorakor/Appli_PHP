

<?php 

/*
recap.php devra nous permettre d'afficher de manière organisée et exhaustive la liste des produits présents en session. Elle doit également présenter le total de l'ensemble de ceux-ci.
*/

    session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Récapitulatif des produits</title>
</head>
<body>
    <?php 
    
    //var_dump($_SESSION);


    // condition qui vérifie que la clé "products" du tableau de session $_SESSION n'existe pas avec  !isset() ou que cette clé existe mais ne contient aucune donnée : empty()
    if ( !isset($_SESSION['products']) || empty($_SESSION['products']) ) {


        // on prévient l'utilisateur qu'aucun produit n'existe en session dans les deux cas précédents.
        echo "<p>Aucun produit en session.</p>";
    }

    // Il ne nous reste plus qu'à afficher le contenu de $_SESSION['products'] dans la partie else de notre condition.
    else {
        echo "<table>",
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

</body>
</html>


