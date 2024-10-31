<?php
    session_start();


    // Il faut donc limiter l'accès à traitement.php par les seules requêtes HTTP provenant de la soumission de notre formulaire.
    // Pour cela, une condition simple doit être effectuée :
    if(isset($_POST['submit'])) {


        // La fonction PHP filter_input() permet d'effectuer une validation ou un nettoyage de chaque donnée transmise par le formulaire, en employant divers filtres.
        // FILTER_SANITIZE_STRING (champ "name") : ce filtre supprime une chaîne de caractères de toute présence de caractères spéciaux et de toute balise HTML potentielle ou les encode.
        // FILTER_VALIDATE_FLOAT (champ "price") : validera le prix que s'il est un nombre à virgule (pas de texte ou autre…).
        // FILTER_FLAG_ALLOW_FRACTION est ajouté pour permettre l'utilisation du caractère "," ou "." pour la décimale.
        // FILTER_VALIDATE_INT (champ "qtt") : ne validera la quantité que si celle-ci est un nombre entier différent de zéro (qui est considéré comme nul).
        $name = filter_input(INPUT,POST, "name", FILTER_SANITIZE_STRING);
        $price = filter_input(INPUT,POST, "price", FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $name = filter_input(INPUT,POST, "qtt", FILTER_VALIDATE_INT);

        // On vérifie si Les filtres ont tous fonctionné grâce à une nouvelle condition.
        // Sachant qu'un filtre renverra false ou null s'il échoue, et que nous ne pouvons pas anticiper la saisie de l'utilisateur à ce niveau, il suffit de vérifier implicitement si chaque variable contient une valeur jugée positive par PHP (du texte, des nombres, etc., autrement dit tout sauf false ou null ou 0). Voilà pourquoi la condition ne compare les variables à rien de précis.
        // Pour faire simple, on vérifie qu'on n'obtient pas du false, du null ou du 0 (pas de choses trop pourries)
        if($name AND $price AND $qtt) {


            // on construit pour chaque produit un tableau associatif $product
            // organisation des données nous permettra d'afficher nos produits plus tard de manière plus efficace et de rendre notre code plus explicite.
            $product = [
                "name" => $name,
                "price" => $price,
                "qtt" => $qtt,
                "total" => $price*$qtt,
            ];


            // on enregistre ce produit nouvellement créé en session
            // on sollicite le tableau de session $_SESSION fourni par PHP (on se sert des choses mises à disposition)
            // on indique la clé "products" de ce tableau. Si cette clé n'existait pas auparavant (ex: l'utilisateur ajoute son tout premier produit), PHP la créera au sein de $_SESSION.
            // Les deux crochets "[]"sont un raccourci pour indiquer à cet emplacement que nous ajoutons une nouvelle entrée au futur tableau "products" associé à cette clé. $_SESSION["products"] doit être lui aussi un tableau afin d'y stocker de nouveaux produits par la suite.
            $_SESSION['products'][] = $product;
            

        }


    }

    header("Location:index.php");
    // Nous vérifions alors l'existence de la clé "submit" dans le tableau $_POST, celle clé correspondant à l'attribut "name" du bouton <input type="submit" name="submit"> du formulaire. La condition sera alors vraie seulement si la requête POST transmet bien une clé "submit" au serveur.
