<?php

use Faker\Factory;
use App\Entity\User;
use App\Entity\Panier;
use App\Entity\Product;
use App\Entity\Commandes;

//fichier neccessaire : chermin vers bootstrap.php 
require_once "bootstrap.php";

//fichier neccessaire : chermin vers fichier entity.php 
require_once "src/Entity/User.php";
require_once "src/Entity/Commandes.php";
require_once "src/Entity/Panier.php";
require_once "src/Entity/Product.php";


// Faker\Generator instance
$faker = Factory::create();

/* creer des fake 50 fake users
//create user
$userNum = 50;
$password = "azerty123";

for ($i = 0; $i < $userNum; $i++) {
    $createUser = (new User())->setFullname($faker->name())
        ->setEmail($faker->email())
        ->setPassword(sha1($password));

    $em->persist($createUser);
    $users[] = $createUser;
}

*/

//créer 100 fake product
$productNum = 100;

for ($i = 0; $i < $productNum; $i++) {
    $createProduct = (new Product())->setP_name($faker->name())
        ->setDescription($faker->text(rand(200, 250)))
        ->setPrice(rand(100, 10000))
        ->setProductUrl($faker->imageUrl(360, 360, 'animals', true, 'cats'));

    $em->persist($createProduct);
    $prodcuts[] = $createProduct;
}

$em->flush();

/* créer 20 fake panier pour des users au hasard
//create panier
$panierNum = 20;

for ($i = 0; $i < $panierNum; $i++) {
    $createPanier = (new Panier())->setCommander($users[rand(0, $userNum - 1)])
        ->addProducts($prodcuts[rand(0, $productNum - 1)])
        ->addProducts($prodcuts[rand(0, $productNum - 1)])
        ->addProducts($prodcuts[rand(0, $productNum - 1)])
        ->addProducts($prodcuts[rand(0, $productNum - 1)]);
    // ->setCommandePanier($i + 1);

    $em->persist($createPanier);
    $paniers[] = $createPanier;
}
$em->flush();

*/


/* créer 20 fake commandes
//create commande
$commandeNum = 20;

for ($i = 0; $i < $commandeNum; $i++) {
    $createCommande = (new Commandes())->setFacture(rand(1000, 5000))
        ->setCommander($users[rand(0, $userNum - 1)])
        ->setPanierCommande($paniers[$i]);

    $em->persist($createCommande);
}
$em->flush();
*/