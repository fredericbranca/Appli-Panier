<?php
session_start();
ob_start();

?>

<!-- Accueil -->

<section class="accueil w-100 h-100">

    <div class="container flex-column d-flex align-items-center">

        <h1 class="display-4 text-black text-center mb-4">Ajouter un produit</h1>
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

    <?php
        $content = ob_get_clean();
        $titre = "Ajouter un produit";
        $accueil = "active";
        require "template.php";
    ?>