<?php
session_start();

use App\Entity\User;
use App\Entity\Panier;
use App\Entity\Product;
use App\Entity\Commandes;
use Slim\Views\PhpRenderer;
use Slim\Factory\AppFactory;

require_once dirname(__DIR__) . "/bootstrap.php";

// Create App
$app = AppFactory::create();

//charger les produits
$productsRepo = $GLOBALS["em"]->getRepository(Product::class);
$products = $productsRepo->findAll();

//add route : /
$app->get('/', function ($request, $response) {
    $renderer = new PhpRenderer(dirname(__DIR__) . '/templates');

    $viewData = [
        'name' => 'Products',
        "products" => $GLOBALS["products"]
    ];

    return $renderer->render($response, '/home/home.php', $viewData);
})->setName('profile');


//add route : panier : get -> add product to basket
$app->get('/panier/{product_id}', function ($request, $response) {
    $renderer = new PhpRenderer(dirname(__DIR__) . '/templates');

    $product_id = $request->getAttribute('product_id');
    $productsRepo = $GLOBALS["em"]->getRepository(Product::class);
    $product = $productsRepo->find($product_id);

    if (!$product) {
        $product[] = [];
    }


    $viewData = [
        'name' => 'Mon Panier',
        "products" => $product
    ];

    return $renderer->render($response, '/panier/panier.php', $viewData);
})->setName('profile');

//add route : panier : get -> vider ou annuler panier
$app->post('/panier/mon_panier', function ($request, $response) {
    $renderer = new PhpRenderer(dirname(__DIR__) . '/templates');
    $annuler = $request->getParsedBody();
    $annuler_value = $annuler["annuler_value"];
    // var_dump($annuler_value);
    // exit(1);
    if ($annuler_value === "annuler") {
        $product["annuler"] = "annuler";
    }

    $viewData = [
        'name' => 'Mon Panier',
        "products" => $product
    ];

    return $renderer->render($response, '/panier/panier.php', $viewData);
})->setName('profile');

//add route : panier : get -> profil
$app->get('/commandes/{user_id}', function ($request, $response) {
    $renderer = new PhpRenderer(dirname(__DIR__) . '/templates');

    $user_id = $request->getAttribute('user_id');
    $usersRepo = $GLOBALS["em"]->getRepository(User::class);
    $user = $usersRepo->find($user_id);

    //recuperer les cmds de user si user_id est correct et cmd exist
    if ($user) {
        $cmdRepo = $GLOBALS["em"]->getRepository(Commandes::class);
        $cmds = $cmdRepo->findBy(array('commander' => $user));

        if (count($cmds) == 0) {
            $cmds = [];
        }
    } else {
        $cmds = [];
    }


    if (($_SESSION["user"]["id"]) != $user_id) {
        $cmds = [];
    }

    // var_dump($cmds[0]->getPanierCommande()->getProducts()->getValues());
    // exit(1);
    $viewData = [
        'name' => 'Mes Commandes',
        "commandes" => $cmds
    ];

    return $renderer->render($response, '/commandes/commandes.php', $viewData);
})->setName('profile');

//add route : commandes : post -> enregistrer commande
$app->post('/saveCmds', function ($request, $response) {
    $renderer = new PhpRenderer(dirname(__DIR__) . '/templates');
    $products = $request->getParsedBody();

    $nbre_produit = $products["nbre_produit"];
    unset($products["nbre_produit"]);

    //on recupere user via son id
    $userRepo = $GLOBALS["em"]->getRepository(User::class);
    $user = $userRepo->findBy(array('email' => $_SESSION["user"]["email"]));

    //on cree la panier
    $createPanier = (new Panier())->setCommander($user[0]);
    //on recupere l'entite product, s'il exist on le sauvegarde dans panier
    $productsRepo = $GLOBALS["em"]->getRepository(Product::class);

    //facture
    $facture = 0;

    foreach ($products as $product_id) {
        //si produit exist, on l'ajoute au panier
        if ($productGet = $productsRepo->find($product_id)) {
            $createPanier->addProducts($productGet);
            $GLOBALS["em"]->persist($createPanier);
            $facture += $productGet->getPrice();
        }
    }

    $GLOBALS["em"]->flush();

    //on cree la commande
    $createCommande = (new Commandes())->setFacture($facture * 1.25)
        ->setCommander($user[0])
        ->setPanierCommande($createPanier);

    $GLOBALS["em"]->persist($createCommande);
    $GLOBALS["em"]->flush();

    //on supprime les produits commandés de la base de donnee de produits
    foreach ($products as $product_id) {
        //si produit exist, on le supprime
        if ($productGet = $productsRepo->find($product_id)) {
            $GLOBALS["em"]->remove($productGet);
            $GLOBALS["em"]->flush();
        }
    }


    //on charge les commandes
    $cmdRepo = $GLOBALS["em"]->getRepository(Commandes::class);
    $cmds = $cmdRepo->findBy(array('commander' => $user[0]));

    // var_dump($cmds[0]->getPanierCommande()->getProducts()->getValues());
    // exit(1);

    if (count($cmds) == 0) {
        $cmds = [];
    }

    $viewData = [
        'name' => 'Mes Commandes',
        "commandes" => $cmds,
        "viderPanier" => 1
    ];

    return $renderer->render($response, '/commandes/commandes.php', $viewData);
})->setName('profile');

//add route : logout : get
$app->get('/logout', function ($request, $response) {
    $renderer = new PhpRenderer(dirname(__DIR__) . '/templates');

    $viewData = [
        "name" => "Home Page"
    ];

    return $renderer->render($response, '/logout/logout.php', $viewData);
})->setName('profile');


//add route : log in : se connecter : post
$app->post('/login', function ($request, $response) {
    $renderer = new PhpRenderer(dirname(__DIR__) . '/templates');
    $userParams = $request->getParsedBody();

    $email = $userParams["email"];
    $pwd = $userParams["pwd"];

    //charger user
    $userRepo = $GLOBALS["em"]->getRepository(User::class);
    $user = $userRepo->findBy(array('email' => $email, 'password' => sha1($pwd)));

    //si pas d'utilisateur trouvé
    if (count($user) == 0) {
        $user[0] = NULL;
    }

    $viewData = [
        'name' => 'Products',
        "products" => $GLOBALS["products"],
        "user" => $user[0]
    ];

    return $renderer->render($response, '/home/home.php', $viewData);
})->setName('profile');

//Add routes : create_account : post
$app->post('/create_account', function ($request, $response) {
    $renderer = new PhpRenderer(dirname(__DIR__) . '/templates');
    $requestData = $request->getParsedBody();

    //clean data
    foreach ($requestData as $key => $value) {
        $data_t = trim($value);
        $data_t = stripslashes($data_t);
        $data_t = strip_tags($data_t);
        $data_t = htmlspecialchars($data_t);
        $requestData[$key] = $data_t;
    }

    //verifiy if email exist
    $user = $GLOBALS["em"]->getRepository(User::class)->findBy(array('email' => $requestData["email"]));

    $message_error = "";

    if (count($user) > 0) {
        $message_error = "this email is already register !";
        $user[0] = NULL;
    } else {
        //create user
        $createUser = (new User())->setFullname($requestData["fullname"])
            ->setEmail($requestData["email"])
            ->setPassword(sha1($requestData["password"]));

        $GLOBALS["em"]->persist($createUser);
        $GLOBALS["em"]->flush();

        $user = $GLOBALS["em"]->getRepository(User::class)->findBy(array('email' => $requestData["email"], 'password' => sha1($requestData["password"])));

        //si pas d'utilisateur trouvé
        if (count($user) == 0) {
            $user[0] = NULL;
        }
    }

    $viewData = [
        'name' => 'Products',
        "products" => $GLOBALS["products"],
        "user" => $user[0]
    ];

    return $renderer->render($response, '/home/home.php', $viewData);
})->setName('profile');

//add route : details
$app->get('/details/{product_id}', function ($request, $response) {
    $renderer = new PhpRenderer(dirname(__DIR__) . '/templates');

    $product_id = $request->getAttribute('product_id');
    $productsRepo = $GLOBALS["em"]->getRepository(Product::class);
    $product = $productsRepo->find($product_id);

    if (!$product) {
        $product[] = [];
    }

    $viewData = [
        'name' => 'Details',
        "products" => $product
    ];

    return $renderer->render($response, '/detail/detail.php', $viewData);
})->setName('profile');

$app->run();
