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
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
        <a class="navbar-brand" href="http://localhost/">Localhost</a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="index.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="Recap.php">Récapitulatif</a>
                    </li>
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
        </div>
    </nav>
</header>

<body>

    <?php 
    // session_destroy();
        if(!isset($_SESSION['products']) || empty($_SESSION['products'])) 
        {
            echo "<p class='ms-3' class='fs-6'>Aucun produit en session...</p>";
        }
        else 
        {
            echo "<div class='ms-3'><p class='fs-2'>Récapitulatif du panier</p></div>",
                "<table  class='table table-hover'>",
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

            $totalGeneral = 0;

            foreach($_SESSION['products'] as $key => $product)
            {
                $totalGeneral += $product['total'];
                echo "<tr>",
                        "<td>".$key."</td>",
                        "<td>".$product['name']."</td>",
                        "<td>".number_format($product['price'], 2, ",", "&nbsp;")."&nbsp;€</td>",
                        "<td>".$product['qtt']."</td>",
                        "<td>".number_format($product['total'], 2, ",", "&nbsp;")."&nbsp;€</td>",
                        "<td><button type='remove' name='remove'><i class='fa-sharp fa-solid fa-square-xmark'></i></button></td>";
                echo "</tr>";

                // if (isset($_POST['remove'])) {
                //         unset($_SESSION['products'][$key]);
                // }

            }

            echo    "<tr>",
                        "<td colspan=4>Total général : </td>",
                        "<td><strong>".number_format($totalGeneral, 2, ",", "&nbsp;"). "&nbsp;€</strong></td>",
                        "<td><a href='Traitement.php?action=clear'><i class='fa-sharp fa-solid fa-square-xmark'></i></a></td>",
                    "</tr>",
                 "</tbody>",
                "</table>";

        }
    
    ?>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

        <!-- curseur -->
            <!-- <div id="cursor"></div> -->
            <div id="circle" class="circle"></div>
            <script type="text/javascript" src="kinet.min.js"></script>
            <script type="text/javascript" src="cursor.js"></script>
</body>
</html>