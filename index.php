
<!-- il faut absolument avoir ces 3 lignes si on veut pouvoir accéder aux produits en session, et pas uniquement dans le fichier recap.php -->
<?php 
    session_start();
?>

<!DOCTYPE html>
<html lang = "fr">
    <head>
        <meta charset = "UTF-8">
        <meta name = "viewport" content = "width=device-width, initial-scale=1.0">
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOMt23cez/3paNdF+Z1p0z6r8gfom0y8c6Qw3D87" crossorigin="anonymous">

        <link rel="stylesheet" href="css/style.css">
        <title>Ajout d'un produit</title>
    </head>
    <body>
        <nav>
            
            <ul class="navbar" id="navbar">
                <li class="menu">
                <a href="recap.php">Voir mon tableau de produits</a>
                </li>
            </ul>
            
        </nav>
        
        <main class="ajoutProduit">
            <h1>
                Ajouter un produit
            </h1>

            <!-- la balise <form> comporte deux attributs.
                1 : action indique la cible du formulaire, le fichier à atteindre lorsque l'utilisateur soumet le formulaire
                2 : method précise par quelle méthode HTTP les données du formulaire sont transmises au serveur -->
            
                <!-- ?action=add à ajouter car le fichier traitement.php propose beaucoup de choses et pas juste l'ajout de produit : il faut donc bien cibler -->
                <form action="traitement.php?action=add" method="post">
                <p>
                    <label for="name">
                        Nom du produit :
                        <input type="text" id="name" name="name" class="formu" required>
                        <!-- Remarque 1 : la balise <input> dispose d'un attribut name, pour permettre à la requête de classer le contenu de la saisie dans des clés portant le nom choisi -->
                        <!-- var_dump($_POST) affichera (après saisie et soumission du formulaire) :

                            array (size=3)
                                'name' -> string 'Pomme' (length=5)
                                'price' -> string '2.5' (length=3)
                                'qtt' -> string '10' (length=2)

                            Les données sont structurées dans le tableau $_POST de la même manière que $_GET, sans être visibles dans l'URL.
                        -->
                    </label>
                </p>
                <p>
                    <!-- L'attribut 'for' dans la balise '<label>' fait référence à l'attribut 'id' de la balise '<input>'.
                    Cela signifie que pour que le lien fonctionne, la valeur de 'for' dans le '<label>' doit correspondre à la valeur de 'id' dans la balise '<input>'. -->
                    <label for="price">
                        Prix du produit :
                        <input type="number" step="any" id="price" name="price" class="formu" required> <!-- idem Remarque 1 et en définissant step="any", les utilisateurs sont autorisés à entrer des valeurs décimales, y compris des fractions, sans aucune restriction. Cela signifie que les utilisateurs peuvent saisir n'importe quel nombre, que ce soit un entier, un nombre décimal avec une précision arbitraire, ou même un nombre irrationnel. -->
                    </label>
                </p>
                <p>
                    <label for="qtt">
                        Quantité désirée :
                        <input type="number" id="qtt" name="qtt" value="1" min="1" class="formu" required> <!-- idem Remarque 1 et valeur par défaut = 1 et au minimum 1 -->
                    </label>
                </p>
                <p>

                    <!-- Le champ <input type="submit"> représente le bouton de soumission du formulaire et contient lui aussi un attribut "name". Nous verrons plus bas que ce choix permettra de vérifier côté serveur que le formulaire a bien été validé par l'utilisateur -->
                    <input type="submit" name="submit" value="Ajouter le produit" class="soumettre">

                </p>
            </form>

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

                <!-- le div qui contient le message à afficher : réussite ou erreur -->
                
                <div class = "message">
                    <?php  

                    // si la variable success est mal définie ou NULL, on n'affiche rien.
                    if(!isset($_SESSION['success']) || empty($_SESSION['success'])){
                        echo "";
                    } 
                    // si la variable success est définie et non NULL, on affiche le message success
                    else {
                        echo "<p class='success'>".$_SESSION['success']."</p>";
                        // unset($variable); supprime complètement la variable $_SESSION['success'], ce qui signifie qu’elle n’est plus définie dans le script. 
                        unset($_SESSION['success']);
                    }

                    // si la variable error est mal définie ou NULL, on n'affiche rien.
                    if(!isset($_SESSION['error']) || empty($_SESSION['error'])){
                        echo "";
                    } 
                    
                    // si la variable error est définie et non NULL, on affiche le message error
                    else {
                        echo "<p class='error'>".$_SESSION['error']."</p>";  
                        // unset($variable); supprime complètement la variable $_SESSION['error'], ce qui signifie qu’elle n’est plus définie dans le script.
                        unset($_SESSION['error']);
                        
                    }

                    ?>

                </div>
        
            </div>
            
        </main>
        

    </body>
</html>
