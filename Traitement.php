<?php

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

                $id++;

                // Check si les valeurs ont été entrées correctement //
                if ($name && $price && $qtt) {

                    // Tableau du produit
                    $product = ['name' => $name, 'price' => $price, 'qtt' => $qtt, 'total' => $price * $qtt];

                    // Ajoute un produit en session
                    $_SESSION['products'][] = $product;

                    // Affiche l'ajout du produit au panier
                    $_SESSION['Message'] = "<div class='green'>Produit ajouté au panier avec succès</div>";

                } else {
                    // Affiche le refus de l'ajout au panier
                    $_SESSION['Message'] = "<div class='red'>Le produit n'a pas été ajouté au panier </div>";
                }
            }
            break; //permet de ne pas passer à la case suivante

            // VIDER LE PANIER //
        case "clear":

            //supprimer le tableau de produits en session
            unset($_SESSION['products']);

            // afficher le message de confirmation du panier vidé
            $_SESSION['Message'] = "<p class='ms-3 fs-6'>Le panier a été vidé !</p>";

            // redirection
            header("Location: Recap.php");
            die();
            break;

            // SUPPRIMER UN PRODUIT //
        case "delete":

            // supprime le produit assoscié à l'id qui lui est attribué grâce à la method GET de l'URL
            unset($_SESSION['products'][$_GET['id']]);

            // mise en forme pour l'affichage : afficher le message de suppression du produit
            if(!empty($_SESSION['products'])){
                $_SESSION['Message'] = "<p class='ms-3 green' >Le produit a été supprimé !</p>";
            }
            else{
                $_SESSION['Message'] = "<p class='ms-3 green' >Le produit a été supprimé !</p>
                                        <p class='ms-3' >Le panier est vide...</p>";

            }
            
            //redirection
            header('Location: Recap.php');
            die();
            break;

            // AUGMENTER LA QUANTITE D'UN PRODUIT //
        case "up-qtt":

            // augmente la quantité d'un produit de 1
            $_SESSION['products'][$_GET['id']]['qtt']++;

            // redirection
            header('Location: Recap.php');
            die();
            break;

            // DIMINUER LA QUANTITE D'UN PRODUIT //
        case "down-qtt":

            // diminue la quantité d'un produit de 1
            $_SESSION['products'][$_GET['id']]['qtt']--;

            // si la quantité passe à 0 
            if($_SESSION['products'][$_GET['id']]['qtt'] == 0 ){

                // supprime le produit assoscié à l'id qui lui est attribué
                unset($_SESSION['products'][$_GET['id']]);

                if(!empty($_SESSION['products'])){
                    // affiche le message de suppression du produit s'il y a encore des produits dans le panier
                    $_SESSION['Message'] = "<p class='ms-3 green' >Le produit a été supprimé !</p>";
                }
                else{
                    // affiche le message de suppression du produit et que le panier est vide
                    $_SESSION['Message'] = "<p class='ms-3 green' >Le produit a été supprimé !</p>
                                            <p class='ms-3' >Le panier est vide...</p>";
                }
            }
            // redirection
            header("Location: Recap.php");
            die();
            break;
    }
}

header("Location:index.php");
