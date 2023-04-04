<?php
    session_start();

require 'functions.php';

if (isset($_GET['action'])) {

    switch ($_GET['action']) {


            // AJOUTER UN PRODUIT (si appel de la case "add")//
        case "add":
            if (isset($_POST['submit'])) {

                // Filtre pour les input //
                $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS); // empèche injection de SQL ou de HTML, supprime toutes les balises

                $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION); //FILTER_VALIDATE_FLOAT (champ "price") : validera le prix que s'il est un nombre à virgule (pas de texte ou autre…), le drapeau FILTER_FLAG_ALLOW_FRACTION est ajouté pour permettre l'utilisation du caractère "," ou "." pour la décimale.

                $qtt = filter_input(INPUT_POST, 'qtt', FILTER_VALIDATE_INT); //ne validera la quantité que si celle-ci est un nombre entier différent de zéro (qui est considéré comme nul)

                $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                // IMAGE //
                if (isset($_FILES['file'])) {

                    $tmpName = $_FILES['file']['tmp_name'];
                    $ImgName = $_FILES['file']['name'];
                    $size = $_FILES['file']['size'];
                    $error = $_FILES['file']['error'];

                    // vérification sur l'extension du fichier //
                    $tabExtension = explode('.', $ImgName);
                    $extension = strtolower(end($tabExtension));
                    //Tableau des extensions que l'on accepte
                    $extensions = ['jpg', 'png', 'jpeg', 'gif'];
                    //Taille max que l'on accepte
                    $maxSize = 4000000;

                    if (in_array($extension, $extensions) && $size <= $maxSize && $error == 0) {
                        $uniqueName = uniqid('', true);
                        //uniqid génère quelque chose comme ca : 5f586bf96dcd38.73540086
                        $file = $uniqueName . "." . $extension;
                        //$file = 5f586bf96dcd38.73540086.jpg
                        move_uploaded_file($tmpName, 'fichierImg/' . $file);

                        // Check si les valeurs ont été entrées correctement //
                        if($name && $price && $qtt && $description) {

                            // Tableau du produit
                            $product = ['name' => $name, 'price' => $price, 'qtt' => $qtt, 'total' => $price * $qtt, 'description' => $description, 'file' => $file];
        
                            // Ajoute un produit en session
                            $_SESSION['products'][] = $product;
        
                            // Affiche l'ajout du produit au panier
                            $_SESSION['Message'] = "<div class='alert alert-success' role='alert'>Produit ajouté au panier avec succès</div>";
                        }
                        else {
                            // Affiche le refus de l'ajout au panier
                            $_SESSION['Message'] = "<div class='alert alert-danger' role='alert'>Nom, Prix, Quantité ou Description contient une erreur </div>";
                        }
                    }
                    else {
                        $_SESSION['Message'] = "<div class='alert alert-danger' role='alert'>Tous les champs sont obligatoires</div>";
                    }
                }
                else{
                    $_SESSION['Message'] = "<div class='alert alert-danger' role='alert'>Le fichier n'est pas une image (.jpg, .png, .jpeg ou .gif) ou la taille de l'image est trop grande</div>";
                }
            }
            else{
                $_SESSION['Message'] = "<div class='alert alert-danger' role='alert'>Erreur formulaire</div>";
            }

            break; //permet de ne pas passer à la case suivante

            // VIDER LE PANIER //
        case "clear":

            //supprime toutes les images temporaire
            foreach($_SESSION["products"] as $k => $p){
                unlink("fichierImg/" . $_SESSION['products'][$k]['file']);
            }

            //supprimer le tableau de produits en session
            unset($_SESSION['products']);

            // afficher le message de confirmation du panier vidé
            $_SESSION['Message'] = "<div class='alert alert-success vide' role='alert'>Le panier a été vidé !</div>";

            // redirection
            header("Location: Recap.php");
            die();
            break;

            // SUPPRIMER UN PRODUIT //
        case "delete":

            // Verifie si "id" est défini dans l'URL et si le produit existe
            if(isset($_GET["id"]) && isset($_SESSION["products"][$_GET["id"]])){

                // supprime le produit assoscié à l'id qui lui est attribué grâce à la method GET de l'URL
                $deletedProduct = $_SESSION['products'][$_GET['id']]['name'];
                unlink("fichierImg/" . $_SESSION['products'][$_GET['id']]['file']);
                unset($_SESSION['products'][$_GET['id']]);
                // mise en forme pour l'affichage : afficher le message de suppression du produit
                if (!empty($_SESSION['products'])) {
                    $_SESSION['Message'] = "<div class='alert alert-success' role='alert'>Le produit $deletedProduct a été supprimé !</div>";
                } else {
                    $_SESSION['Message'] = "<div class='alert alert-success vide' role='alert'>Le produit $deletedProduct a été supprimé !</div>
                                            <div class='alert alert-warning' role='alert'>Le panier a été vidé...</div>";
                }

                //redirection
                header('Location: Recap.php');
                die();
                break;
            }
            else{
                $_SESSION['Message'] = "<div class='alert alert-danger' role='alert'>Cette fonctionnalité n'est pas encore accessible !</div>";

                //redirection
                header('Location: Recap.php');
                die();
                break;
            }

            // AUGMENTER LA QUANTITE D'UN PRODUIT //
        case "up-qtt":

            // Verifie si "id" est défini dans l'URL et si le produit existe
            if(isset($_GET["id"]) && isset($_SESSION["products"][$_GET["id"]])){

                // augmente la quantité d'un produit de 1 si < 1000
                if ($_SESSION['products'][$_GET['id']]['qtt'] < 1000){
                    $_SESSION['products'][$_GET['id']]['qtt']++;
                }
                else{
                    $_SESSION['Message'] = "<div class='alert alert-danger'>Action impossible : Vous avez déjà atteint la quantité maximale !</div>";
                }

                // redirection
                header('Location: Recap.php');
                die();
                break;
            }
            else{
                $_SESSION['Message'] = "<div class='alert alert-danger' role='alert'>Cette fonctionnalité n'est pas encore accessible !</div>";
               
                //redirection
                header('Location: Recap.php');
                die();
                break;
            }

            // DIMINUER LA QUANTITE D'UN PRODUIT //
        case "down-qtt":

            // Verifie si "id" est défini dans l'URL et si le produit existe
            if(isset($_GET["id"]) && isset($_SESSION["products"][$_GET["id"]])){

                $deletedProduct = $_SESSION['products'][$_GET['id']]['name'];

                // diminue la quantité d'un produit de 1
                $_SESSION['products'][$_GET['id']]['qtt']--;

                // si la quantité passe à 0 
                if ($_SESSION['products'][$_GET['id']]['qtt'] == 0) {

                    // supprime le produit assoscié à l'id qui lui est attribué
                    unlink("fichierImg/" . $_SESSION['products'][$_GET['id']]['file']);
                    unset($_SESSION['products'][$_GET['id']]);

                    if (!empty($_SESSION['products'])) {
                        // affiche le message de suppression du produit s'il y a encore des produits dans le panier
                        $_SESSION['Message'] = "<div class='alert alert-warning'>Le produit $deletedProduct a été supprimé !</div>";
                    } else {
                        // affiche le message de suppression du produit et que le panier est vide
                        $_SESSION['Message'] = "<div class='alert alert-warning vide' role='alert'>Le produit $deletedProduct a été supprimé !</div>
                                                <div class='alert alert-warning' role='alert'>Le panier a été vidé...</div>";
                    }
                }
                // redirection
                header("Location: Recap.php");
                die();
                break;
            }
            else
            {
                $_SESSION['Message'] = "<div class='alert alert-danger' role='alert'>Cette fonctionnalité n'est pas encore accessible !</div>";
                
                //redirection
                header('Location: Recap.php');
                die();
                break;
            }
    }
}

header("Location:index.php");
