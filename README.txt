################# App Web de vente en ligne ###################

Description : application web de gestion d'évènement
			écris en PHP, MySql, Doctrine, Jquery

- créez un compte et connectez vous pour continuer !

- onglet "Panier" : liste des produit ajouté à votre panier

- l'onglet "Products", le boutton "Add to..." permet d'ajouter le produit au panier

-l'onglet "products" le button "Details..." permet de voir les détails du produits

- onglet "Panier" : 
	le button "vider le panier" permet de vider le panier
	le button "commande" permet de confirmer la commande


- onglet "commandes" : la liste des commandes



-onglet "se deconnecter" : se deconecter


NB : 
1- creez une base de donnee mysql: onlinesales
2- creer le schema : cmd-> php bin/console orm:schema-tool:create
3- utiliser des fake data (products): cmd -> php dump_data.php


Pour aller plus rapidement :
	creez la base de donnee mysql (onlinesales)
	puis lancer la commande (dans ms visual code) :  php bin/loader

dans le fichier dump_data.php : vous pouver decommenter certaines ligne
			pour avoir des fake users, fake commandes, fake panier
	





Bon usage ;-)

@McKwunthy