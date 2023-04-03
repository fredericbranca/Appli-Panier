<?php
session_start();
ob_start()

?>

    <section class="accueil w-100 h-100">
        <div class="container d-flex flex-column align-items-center ">
            <?php
                //session_destroy(); //permet de supprimer la session en cours

                // S'il n'a pas de message en session et qu'il n'y a pas de produit :
                if (isset($_SESSION['Message']) && empty($_SESSION['products'])) {
                    echo '<h1 class="display-4 text-black text-center">Récapitulatif du panier</h1>';
                    //affiche que le panier a été vidé
                    echo $_SESSION['Message'];
                    unset($_SESSION['Message']);
                }
                //sinon si le tableau de produit est vide
                elseif (!isset($_SESSION['products']) || empty($_SESSION['products'])) {
                    //affiche que le panier est vide
                    echo '<h1 class="display-4 text-black text-center pb-20">Récapitulatif du panier</h1>';
                    echo '<h1 class="display-6 text-black text-center">Le panier est vide...</h1>';
                }
                //sinon (le tableau de produit n'est pas vide)
                else {
                    echo    '<h1 class="display-4 text-black text-center">Récapitulatif du panier</h1>',
                            '</div>', //fermeture 1ere div container
                            '<div class="container align-items-center">',
                                '<div class="table-responsive">',
                                    '<table  class="table table-hover shadow text-nowrap">',
                                        "<thead>",
                                            "<tr>",
                                                '<th scope="col">#</th>',
                                                '<th scope="col">Nom</th>',
                                                '<th scope="col">Prix</th>',
                                                '<th scope="col" class="cell1"> Quantité</th>',
                                                '<th scope="col class="cell"></th>',
                                                '<th scope="col class="cellvide"></th>',
                                                '<th scope="col">Total</th>',
                                                '<th scope="col"></th>',
                                            "</tr>",
                                        "</thead>",
                                        '<tbody class="table-group-divider">';

                    $totalGeneral = 0;
                    $n = 0;

                    foreach ($_SESSION['products'] as $key => $produit) {
                        $n++;
                        $total = $produit['price'] * $produit['qtt'];
                        echo    "<tr>",
                                    "<th scope='row'> $n </th>",
                                    "<td>
                                        <button type='button' class='btn btn-outline-dark py-0' data-bs-toggle='modal' data-bs-target='#exampleModal$key'>" . $_SESSION['products'][$key]['name'] . "</button>",
                                    "</td>",
                                    "<td>" . number_format($produit['price'], 2, ",", "&nbsp;") . "&nbsp;€</td>",
                                    '<td class="cell1">' . $produit['qtt'] . "</td>",
                                    '<td class="cell">',
                                        "<a href='Traitement.php?action=up-qtt&id=$key'><i class='fa-sharp fa-solid fa-plus pe-2'></i></a>",
                                        "<a href='Traitement.php?action=down-qtt&id=$key'><i class='fa-sharp fa-solid fa-minus'></i></a>",
                                    "</td>",
                                    '<td class="cellvide"></td>',
                                    "</td>",
                                    "<td>" . number_format($total, 2, ",", "&nbsp;") . "&nbsp;€</td>",
                                    "<td class='text-center'>",
                                        "<a href='Traitement.php?action=delete&id=$key'><i class='fa-sharp fa-solid fa-square-xmark'></i></a>",
                                    "</td>",
                                "</tr>";

                        $totalGeneral += $total;
                    }

                    echo                "<tr>",
                                            "<td colspan=6>Total général : </td>",
                                            "<td><strong>" . number_format($totalGeneral, 2, ",", "&nbsp;") . "&nbsp;€</strong></td>",
                                            "<td class='text-center'><a href='Traitement.php?action=clear'><i class='fa-sharp fa-solid fa-square-xmark'></i></a></td>",
                                        "</tr>",
                                    "</tbody>",
                                "</table>",
                            "</div>", //fermeture div table responsive
                        "</div>", //fermeture 2eme div container
                        '<div class="container d-flex flex-column align-items-center ">';

                    if (isset($_SESSION['Message'])) {
                        echo $_SESSION['Message'];
                        unset($_SESSION['Message']);
                    }
            
                    echo '</div>'; //fermeture 3eme container

                    foreach ($_SESSION['products'] as $key => $produit) {
                        echo    "<div class='modal fade' id='exampleModal$key' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>",
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
                                        "</div>",
                                    "</div>",
                                "</div>";
                    }
                }

            ?>

        </div>
   

    <?php
        $content = ob_get_clean();
        $titre = "Panier";
        $recap = "active";
        require "template.php";
