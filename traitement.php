<?php
    session_start();

    if(isset($_GET['action'])) {

        switch($_GET['action']) {

            case "add" :

                // notre cas initial qui est repris ici
                if(isset($_POST['submit'])) {

                    // La fonction PHP filter_input() permet d'effectuer une validation ou un nettoyage de chaque donnée transmise par le formulaire, en employant divers filtres.
                    // FILTER_SANITIZE_STRING (champ "name") : ce filtre supprime une chaîne de caractères de toute présence de caractères spéciaux et de toute balise HTML potentielle ou les encode.
                    // FILTER_VALIDATE_FLOAT (champ "price") : validera le prix que s'il est un nombre à virgule (pas de texte ou autre…).
                    // FILTER_FLAG_ALLOW_FRACTION est ajouté pour permettre l'utilisation du caractère "," ou "." pour la décimale.
                    // FILTER_VALIDATE_INT (champ "qtt") : ne validera la quantité que si celle-ci est un nombre entier différent de zéro (qui est considéré comme nul).
                    $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $price = filter_input(INPUT_POST, "price", FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                    $qtt = filter_input(INPUT_POST, "qtt", FILTER_VALIDATE_INT);
                    
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
            
            
                        // on crée une variable success, qui confirmera le bon enregistrement du produit
                        $_SESSION['success'] = "Le produit a été enregistré avec succès";
                        header("Location: index.php");
            
            
                    }
                    // si on obtient de mauvais retours de nos filtres, on passe à cette partie
                    else {
            
                        // on crée une variable erreur, qui avertira d'un problème à l'enregistrement du produit
                        $_SESSION['error'] = "Erreur : veuillez saisir le nom ainsi que le prix du produit";
                        header("Location: index.php");
                                    
                    }
            
            
                }

                break;

            case "delete":

                // on efface le produit identifié par 'id' du tableau des produits grâce à la fonction unset()
                // [$_GET['id'] : ce paramètre récupère un identifiant de produit transmis via la requête HTTP
                // Il est utilisé comme clé pour identifier quel produit spécifique supprimer dans le tableau "products"
                unset($_SESSION['products'][$_GET['id']]);
                $_SESSION['message'] = "Le produit a bien été supprimé";
                header("Location: recap.php");
                break;

                // $_GET est une variable superglobale en PHP, utilisée pour collecter des données envoyées par le biais de l'URL en utilisant la méthode HTTP GET.


            case "clear":

                // on efface le tableau entier des produits en entier
                unset($_SESSION['products']);
                $_SESSION['message'] = "Les produits ont bien été supprimés";
                header("Location: recap.php");
                break;


            case "up-qtt":

                // augmenter la quantité de 1 pour le produit identifié par 'id'
                $_SESSION["products"][$_GET['id']]['qtt'] ++;
                // le total de ce produit est donc modifié puisque la quantité a changé
                $_SESSION["products"][$_GET['id']]['total'] = $_SESSION["products"][$_GET['id']]['price']*$_SESSION["products"][$_GET['id']]['qtt'];

                header("Location: recap.php");
                
                break;


            case "down-qtt":


                // on distingue le cas où la quantité est positive
                if($_SESSION["products"][$_GET['id']]['qtt'] > 0){

                    // diminuer la quantité de 1 pour le produit identifié par 'id'
                    $_SESSION["products"][$_GET['id']]['qtt'] --;
                    // le total de ce produit est donc modifié puisque la quantité a changé
                    $_SESSION["products"][$_GET['id']]['total'] = $_SESSION["products"][$_GET['id']]['price']*$_SESSION["products"][$_GET['id']]['qtt'];
                    header("Location: recap.php");
                } 
                
                else {

                    // si la quantité du produit n'est pas positive, on peut enlever ce produit de notre tableau produits
                    unset($_SESSION["products"][$_GET['id']]);
                    header("Location: recap.php");
                }
                break;



        }

    }
    else {

        // la ligne ci-dessous effectue une redirection grâce à la fonction header(). Il n'y a pas désormais un "else" à la condition de la ligne 8 puisque nous ne souhaitons plus nécessairement revenir au formulaire après traitement.
        header("Location:index.php");
        // du coup, on va rediriger le client directement vers la page indiquée pour éviter qu'il n'ait accès à la page traitement.php.

    }
   

    // pourquoi la ligne de code 11 : if(isset($_POST['submit']))
    // Il faut donc limiter l'accès à traitement.php par les seules requêtes HTTP provenant de la soumission de notre formulaire.
    // Pour cela, une condition simple doit être effectuée :
    // Nous vérifions alors l'existence de la clé "submit" dans le tableau $_POST, celle clé correspondant à l'attribut "name" du bouton <input type="submit" name="submit"> du formulaire. La condition sera alors vraie seulement si la requête POST transmet bien une clé "submit" au serveur.
    

    
    
    
    
