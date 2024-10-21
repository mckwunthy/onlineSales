<?php
//si user existe on charge les infos user
if (isset($user)) {
    if (!$user == NULL) {
        $_SESSION["user"]["id"] = $user->getId();
        $_SESSION["user"]["email"] = $user->getEmail();
        $_SESSION["user"]["fullname"] = $user->getFullname();
        //on cree un panier vide
        $_SESSION["panier"] = [];

        $content = '';
    } else {
        $content = '
        <div class="d-grid gap-2">
            <button class="btn btn-warning" type="button">an error occur ! please try again</button>
        </div>
        ';
    }
} else {
    $content = '';
}

$content .= '<h3 class="pageName">' . $name . ' </h3>';
$content .= '<div class="row">';

foreach ($products as $product) {
    $content .= '<div class="col">
    <div class="card productsIndiv" style="width: 18rem;">
                <div class="productImg"  style="background-image: url(' . $product->getProductUrl() . ')">
                </div>
                <div class="card-body">
                    <h5 class="card-title">' . $product->getP_name() . '</h5>
                    <p class="card-text">' .  substr($product->getDescription(), 0, 80) . '...</p>
                    <p class="card-text">Price
                    (<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-currency-bitcoin" viewBox="0 0 16 16">
        <path d="M5.5 13v1.25c0 .138.112.25.25.25h1a.25.25 0 0 0 .25-.25V13h.5v1.25c0 .138.112.25.25.25h1a.25.25 0 0 0 .25-.25V13h.084c1.992 0 3.416-1.033 3.416-2.82 0-1.502-1.007-2.323-2.186-2.44v-.088c.97-.242 1.683-.974 1.683-2.19C11.997 3.93 10.847 3 9.092 3H9V1.75a.25.25 0 0 0-.25-.25h-1a.25.25 0 0 0-.25.25V3h-.573V1.75a.25.25 0 0 0-.25-.25H5.75a.25.25 0 0 0-.25.25V3l-1.998.011a.25.25 0 0 0-.25.25v.989c0 .137.11.25.248.25l.755-.005a.75.75 0 0 1 .745.75v5.505a.75.75 0 0 1-.75.75l-.748.011a.25.25 0 0 0-.25.25v1c0 .138.112.25.25.25zm1.427-8.513h1.719c.906 0 1.438.498 1.438 1.312 0 .871-.575 1.362-1.877 1.362h-1.28zm0 4.051h1.84c1.137 0 1.756.58 1.756 1.524 0 .953-.626 1.45-2.158 1.45H6.927z"/>
        </svg>): ' . number_format($product->getPrice(), 1, ',', ' ')  . '</p>
                    <div class="d-flex g-1">
                        <a href="/details/' . $product->getId() . '" class="btn btn-dark flex-grow-1">Details...</a>
                        ';
    if (isset($_SESSION["user"])) {
        $content .= '
        <a href="/panier/' . $product->getId() . '" class="btn btn-warning flex-grow-1">Add to <svg
        xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart3"
        viewBox="0 0 16 16">
        <path
            d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l.84 4.479 9.144-.459L13.89 4zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2" />
    </svg></a>
            ';
    }
    $content .= '
</div>
</div>
</div>
</div>';
}
$content .= '</div>';

//require base.php file
require_once(dirname(__DIR__) . "/base.php");
