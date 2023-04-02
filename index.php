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

    <title>Panier</title>
</head>
<header>

    <!-- Navbar -->

    <nav class="navbar navbar-expand-sm bg-l-light">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Ajouter un produit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="text navbar-nav justify-content-end flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php">Accueil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="Recap.php">Récaputitulatif</a>
                        </li>
                    </ul>
                    <button class="panier border-0 bg-white">
                            <a class="text-black" href="Recap.php">
                                <i class="fa-solid fa-cart-shopping text-dark"></i><span class="nb badge text-bg-primary"><?php echo sumQtt(); ?></span>
                            </a>
                    </button>
                </div>
            </div>
        </div>
    </nav>


</header>

<body>

    <!-- Accueil -->

    <section class="accueil w-100 h-100">

        <div class="container flex-column d-flex align-items-center">

            <h1 class="display-4 text-black text-center p-2">Ajouter un produit</h1>
            <form action="Traitement.php?action=add" method="post" enctype="multipart/form-data">

                <div class="input-group mb-3">
                    <input type="text" name="name" class="form-control" maxlength="30" placeholder="Nom du produit" aria-label="name" aria-describedby="basic-addon1" autocomplete="off">
                </div>

                <div class="input-group mb-3">
                    <input type="number" min="0.01" max="999999" step="0.01" name="price" class="form-control" placeholder="Prix" aria-label="name" aria-describedby="basic-addon1" autocomplete="off">
                    <span class="input-group-text">€</span>
                </div>

                <div class="input-group mb-3">
                    <input type="number" min="1" max="1000" step="1" name="qtt" class="form-control" placeholder="Quantité désirée" aria-label="name" aria-describedby="basic-addon1" autocomplete="off">
                </div>

                <div class="input-group mb-3">
                    <input type="text" name="description" class="form-control" maxlength="400" placeholder="Description" aria-label="name" aria-describedby="basic-addon1" autocomplete="off">
                </div>

                <div class="input-group mb-3">
                    <input type="file" name="file" class="form-control" id="inputGroupFile01">
                    <label class="input-group-text" for="inputGroupFile01">Image</label>
                </div>

                <div class="d-grid gap-2 col-6 mx-auto">
                    <button type="submit" name="submit" class="btn btn-outline-secondary submit">Ajouter le produit</button>
                </div>

            </form>

            <?php
            if (isset($_SESSION['Message'])) {
                echo $_SESSION['Message'];
                unset($_SESSION['Message']);
            }
            ?>

        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <!-- curseur -->
    <div id="circle" class="circle"></div>
    <script type="text/javascript" src="kinet.min.js"></script>
    <script type="text/javascript" src="cursor.js"></script>

</body>

</html>