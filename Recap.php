<?php

require "functions.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/de7e6c09fa.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<header>
    <!-- barre de navigation -->
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
        <!-- Redirection localhost -->
        <a class="navbar-brand" href="index.php">Localhost</a>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <!-- Accueil -->
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="index.php">Accueil</a>
                    </li>
                    <!-- Récapitulatif -->
                    <li class="nav-item">
                        <a class="nav-link active" href="Recap.php">Récapitulatif</a>
                    </li>
                    <!-- panier + quantité -->
                    <li class="nav-item">
                        <div class="session">
                            <div class="btn btn-primary position-relative">
                                <i class="fa-solid fa-cart-shopping"></i>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    <?php echo sumQtt() ?>
                                </span>
                            </div>
                        </div>
                    </li>
                </ul>
        </div>
    </nav>
</header>

<body>
    
        <?php 
        // session_destroy(); //permet de supprimer la session en cours

        // S'il n'a pas de message en session et qu'il n'y a pas de produit :
        if(isset($_SESSION['Message']) && empty($_SESSION['products'])){
            echo "<p class='fs-2 ms-3'>Récapitulatif du panier</p>";
            //affiche que le panier a été vidé
            echo $_SESSION['Message'];
            unset($_SESSION['Message']);
        }
        //sinon si le tableau de produit est vide
        elseif(!isset($_SESSION['products']) || empty($_SESSION['products'])) 
        {
            //affiche que le panier est vide
            echo "<p class='fs-2 ms-3'>Récapitulatif du panier</p>";
            echo "<p class='ms-3 fs-6'>Le panier est vide...</p>";
        }
        //sinon (le tableau de produit n'est pas vide)
        else 
        {
            echo "<p class='fs-2 ms-3 shadow-sm p-3 mb-5 bg-body rounded'>Récapitulatif du panier</p>",
                "<table  class='table table-hover shadow-sm p-3 mb-5 bg-body rounded'>",
                    "<thead>",
                        "<tr>",
                            "<th>#</th>",
                            "<th>Nom</th>",
                            "<th>Prix</th>",
                            "<th>Quantité</th>",
                            "<th>Total</th>",
                            "<th></th>",
                        "</tr>",
                    "</thead>",
                    "<tbody>";

            $totalGeneral = 0;

            foreach($_SESSION['products'] as $key => $produit)
            {
                $total = $produit['price'] * $produit['qtt'];
                echo "<tr>",
                        "<td>".($key+1)."</td>",
                        "<td>
                            <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#exampleModal$key'>" . $_SESSION['products'][$key]['name'] . "</button>",
                        "</td>",
                        "<td>".number_format($produit['price'], 2, ",", "&nbsp;")."&nbsp;€</td>",
                        "<td>".$produit['qtt']. "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp",
                        "<a href='Traitement.php?action=up-qtt&id=$key'><i class='fa-sharp fa-solid fa-plus'></i></a>&nbsp&nbsp",
                        "<a href='Traitement.php?action=down-qtt&id=$key'><i class='fa-sharp fa-solid fa-minus'></i></a></td>",

                        "<td>".number_format($total, 2, ",", "&nbsp;")."&nbsp;€</td>",
                        "<td><a href='Traitement.php?action=delete&id=$key'><i class='fa-sharp fa-solid fa-square-xmark'></i></a></td>";
                echo "</tr>";
                $totalGeneral += $total;
            }

            echo    "<tr>",
                        "<td colspan=4>Total général : </td>",
                        "<td><strong>".number_format($totalGeneral, 2, ",", "&nbsp;"). "&nbsp;€</strong></td>",
                        "<td><a href='Traitement.php?action=clear'><i class='fa-sharp fa-solid fa-square-xmark'></i></a></td>",
                    "</tr>",
                 "</tbody>",
                "</table>";

            if(isset($_SESSION['Message'])){
                echo $_SESSION['Message'];
                unset($_SESSION['Message']);
            }

            foreach($_SESSION['products'] as $key => $produit)
            {
                echo "<div class='modal fade' id='exampleModal$key' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>",
                    "<div class='modal-dialog'>",
                        "<div class='modal-content'>",
                            "<img class='img-thumbnail' src='fichierImg/" . $_SESSION['products'][$key]['file'] . "' alt='Image du produit'/>",
                                "<div class='modal-header'>",
                                    "<p class='modal-title fs-5' id='exampleModalLabel'>" . $_SESSION['products'][$key]['name'] . "</p>",
                                    "<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>",
                                "</div>",
                                "<div class='modal-body'>",
                                    "<p>" . $_SESSION['products'][$key]['description'] . "</p>",
                                "</div>",
                                "<div class='modal-footer'>",
                                    "<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>",
                                    "<button type='button' class='btn btn-primary'>Save changes</button>",
                                "</div>",
                        "</div>",
                    "</div>",
                "</div>";
            }
        }
    
    ?>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

        <!-- curseur -->
            <div id="circle" class="circle"></div>
            <script type="text/javascript" src="kinet.min.js"></script>
            <script type="text/javascript" src="cursor.js"></script>

</body>
</html>
