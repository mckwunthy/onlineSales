<?php
$qty = 1;

if (gettype($products) === "object") {
    $indexOf = NULL;
    foreach ($_SESSION["panier"] as $key => $value) {
        if ($value["name"] == $products->getP_name()) {
            $indexOf = $key;
        }
    }
    //pour eviter les repetition darticle on incremente leur qte
    if (gettype($indexOf) === "integer") {
        $_SESSION["panier"][$indexOf]["qty"] += 1;
        $_SESSION["panier"][$indexOf]["total_price"] = $_SESSION["panier"][$indexOf]["qty"] * $_SESSION["panier"][$indexOf]["unit_price"];
    } else {
        //dans le cas contraire on enregistre le nouvel article
        $_SESSION["panier"][] = [
            "name" => $products->getP_name(),
            "qty" => $qty,
            "unit_price" => $products->getPrice(),
            "total_price" => $products->getPrice() * $qty,
            "product_id" => $products->getId()
        ];
    }
}

// var_dump($_SESSION["panier"]);
// exit(1);
if (gettype($products) === "array" && isset($products["annuler"])) {
    $_SESSION["panier"] = [];
}

$content = '<h3 class="pageName">' . $name . ' </h3>';
$content .= '
<div class="row row-factureTable">
<table class="table-light factureTable">
<tr class="table-light">
<th class="table-light">#</th>
<th class="table-light">Product(s)</th>
<th class="table-light">Quantity</th>
<th class="table-light">U. Price (<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-currency-bitcoin" viewBox="0 0 16 16">
        <path d="M5.5 13v1.25c0 .138.112.25.25.25h1a.25.25 0 0 0 .25-.25V13h.5v1.25c0 .138.112.25.25.25h1a.25.25 0 0 0 .25-.25V13h.084c1.992 0 3.416-1.033 3.416-2.82 0-1.502-1.007-2.323-2.186-2.44v-.088c.97-.242 1.683-.974 1.683-2.19C11.997 3.93 10.847 3 9.092 3H9V1.75a.25.25 0 0 0-.25-.25h-1a.25.25 0 0 0-.25.25V3h-.573V1.75a.25.25 0 0 0-.25-.25H5.75a.25.25 0 0 0-.25.25V3l-1.998.011a.25.25 0 0 0-.25.25v.989c0 .137.11.25.248.25l.755-.005a.75.75 0 0 1 .745.75v5.505a.75.75 0 0 1-.75.75l-.748.011a.25.25 0 0 0-.25.25v1c0 .138.112.25.25.25zm1.427-8.513h1.719c.906 0 1.438.498 1.438 1.312 0 .871-.575 1.362-1.877 1.362h-1.28zm0 4.051h1.84c1.137 0 1.756.58 1.756 1.524 0 .953-.626 1.45-2.158 1.45H6.927z"/>
        </svg>)</th>
<th class="table-light">Tot. Price (<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-currency-bitcoin" viewBox="0 0 16 16">
        <path d="M5.5 13v1.25c0 .138.112.25.25.25h1a.25.25 0 0 0 .25-.25V13h.5v1.25c0 .138.112.25.25.25h1a.25.25 0 0 0 .25-.25V13h.084c1.992 0 3.416-1.033 3.416-2.82 0-1.502-1.007-2.323-2.186-2.44v-.088c.97-.242 1.683-.974 1.683-2.19C11.997 3.93 10.847 3 9.092 3H9V1.75a.25.25 0 0 0-.25-.25h-1a.25.25 0 0 0-.25.25V3h-.573V1.75a.25.25 0 0 0-.25-.25H5.75a.25.25 0 0 0-.25.25V3l-1.998.011a.25.25 0 0 0-.25.25v.989c0 .137.11.25.248.25l.755-.005a.75.75 0 0 1 .745.75v5.505a.75.75 0 0 1-.75.75l-.748.011a.25.25 0 0 0-.25.25v1c0 .138.112.25.25.25zm1.427-8.513h1.719c.906 0 1.438.498 1.438 1.312 0 .871-.575 1.362-1.877 1.362h-1.28zm0 4.051h1.84c1.137 0 1.756.58 1.756 1.524 0 .953-.626 1.45-2.158 1.45H6.927z"/>
        </svg>)</th>
</tr>';
$total_ht = 0;
foreach ($_SESSION["panier"] as $key => $value) {
    $content .= '
<tr class="table-light">
    <td class="table-light">' . $key + 1 . '</td>
<td class="table-light">' . $value["name"] . '</td>
<td class="table-light">' . $value["qty"] . '</td>
<td class="table-light">' . number_format($value["unit_price"], 1, ',', ' ') . '</td>
<td class="table-light">' . number_format($value["total_price"], 1, ',', ' ') . '</td>
</tr>
<!--fin boucle-->
';

    $total_ht += $value["total_price"];
}
$content .= '
<tr class="table-light">
    <td colspan="3" class="table-light">Total HT</td>
    <td class="table-light">-</td>
    <td class="table-light"><strong>' .
    number_format($total_ht, 1, ',', ' ') . '</strong></td>
</tr>
<tr class="table-light">
    <td colspan="3" class="table-light">TVA</td>
    <td class="table-light">25%</td>
    <td class="table-light"><strong>' . number_format($total_ht * 0.25, 1, ',', ' ') . '</strong></td>
</tr>
<tr class="table-light">
    <td colspan="3" class="table-light">Total TTC</td>
    <td class="table-light">-</td>
    <td class="table-light"><strong>' . number_format($total_ht * 1.25, 1, ',', ' ') . '</strong></td>
</tr>
</table>
</div>';

if (count($_SESSION["panier"]) > 0) {
    $content .= '
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
    <button class="btn btn-warning me-md-2" type="button">
        <form method="POST" action="/panier/mon_panier">
            <input type="hidden" value="annuler" name="annuler_value">
            <input type="submit" class="annuler_bt" name="annuler_bt" value="Vider panier">
        </form>
    </button>';
    //reoganisation du tablx session panier pour obtenir les qty
    $product_qty = []; //la position de chaqu qty correspond au produit
    foreach ($_SESSION["panier"] as $product) {
        $product_qty[] = $product["qty"];
    }

    $nbre_produit = 0;
    foreach ($product_qty as $value) {
        $nbre_produit += $value;
    }
    // var_dump($product_qty);
    // var_dump($nbre_produit);
    // exit(1);
    $content .= ' <button class="btn btn-success" type="button">
        <form method="POST" action="/saveCmds">';
    $content .= '<input type="hidden" name="nbre_produit" value="' . $nbre_produit . '">';
    //on parcour chaque qty du tablx
    for ($i = 0; $i < count($product_qty); $i++) {
        for ($j = 0; $j < $product_qty[$i]; $j++) {
            $content .= '<input type="hidden" name="' . $nbre_produit-- . '" value="' . $_SESSION["panier"][$i]["product_id"] . '">';
        }
    }

    $content .= '
            <input type="submit" value="Commander" class="commander_bt">
        </form>
    </button>
    </div>';
} else {
    $content .= '
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
    <button class="btn btn-danger" type="button">Votre panier est vide</button>
    </div>';
}

//require base.php file
require_once(dirname(__DIR__) . "/base.php");
