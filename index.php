<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ajout produit</title>
    </head>
    <body>

        <h1>
            Ajouter un produit
        </h1>

        <!-- la balise <form> comporte deux attributs.
            1 : action indique la cible du formulaire, le fichier à atteindre lorsque l'utilisateur soumet le formulaire
            2 : method précise par quelle méthode HTTP les données du formulaire sont transmises au serveur -->
        
        <form action="traitement.php" method="post">
            <p>
                <label for="name>
                    Nom du produit :
                    <input type="text" id="name" name="name">
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
                    <input type="number" step="any" id="price" name="price"> <!-- idem Remarque 1 -->
                </label>
            </p>
            <p>
                <label for="qtt">
                    Quantité désirée :
                    <input type="number" id="qtt" name="qtt" value="1"> <!-- idem Remarque 1 -->
                </label>
            </p>
            <p>

                <!-- Le champ <input type="submit"> représente le bouton de soumission du formulaire et contient lui aussi un attribut "name". Nous verrons plus bas que ce choix permettra de vérifier côté serveur que le formulaire a bien été validé par l'utilisateur -->
                <input type="submit" name="submit" value="Ajouter le produit">

            </p>
        </form>

    </body>
</html>
