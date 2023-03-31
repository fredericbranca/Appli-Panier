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

    <title>Ajout produit</title>
</head>
<header>
    <nav class="navbar navbar-expand-lg bg-light ">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Localhost</a>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Recap.php">Récapitulatif</a>
                    </li>
                    <li class="nav-item">
                        <div class="session">
                            <div class="btn btn-primary position-relative">
                                <a href="Recap.php"><i class="fa-solid fa-cart-shopping"></i></a>
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

    <form action="Traitement.php?action=add" method="post" enctype="multipart/form-data">
        <div class="ms-3 shadow p-3 mb-5 bg-body rounded">
            <p class="fs-2 shadow-sm p-3 mb-5 bg-body rounded">Ajouter un produit</p>
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text" id="inputGroupPrepend">Nom du produit</span>
                    <input type="text" name="name" class="form-control" aria-describedby="inputGroupPrepend" autocomplete="off">
                </div>
            </div>

            <p>
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text" id="inputGroupPrepend">Prix du produit&nbsp;&nbsp;</span>
                    <input type="number" min="0.01" step="0.01" name="price" class="form-control" aria-describedby="inputGroupPrepend" autocomplete="off">
                    <span class="input-group-text" id="basic-addon1">€</span>
                </div>
            </div>
            </p>

            <p>
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text" id="inputGroupPrepend">Quantité désirée</span>
                    <input type="number" min="1" step="1" name="qtt" value="1" class="form-control" aria-describedby="inputGroupPrepend" autocomplete="off">
                </div>
            </div>
            </p>

            <p>
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text" id="inputGroupPrepend">Image</span>
                    <input type="file" name="file" class="form-control" aria-describedby="inputGroupPrepend" autocomplete="off">
                </div>
            </div>
            </p>

            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text" id="inputGroupPrepend">Description du produit</span>
                    <input type="text" name="description" class="form-control" aria-describedby="inputGroupPrepend" autocomplete="off">
                </div>
            </div>

            <p>
            <div class="col-12">
                <button class="btn btn-primary" name="submit" type="submit">Ajouter le produit</button>
            </div>
            </p>

            <p> <?php 
                    if(isset($_SESSION['Message'])){
                        echo $_SESSION['Message'];
                        unset($_SESSION['Message']);
                    }
                ?>
            </p>


        </div>
    </div>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>


    <!-- curseur -->
        <div id="circle" class="circle"></div>
        <script type="text/javascript" src="kinet.min.js"></script>
        <script type="text/javascript" src="cursor.js"></script>

</body>

</html>