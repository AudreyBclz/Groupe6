<?php

	require 'vendor/autoload.php';
	require 'src/elements/head.php';

	$router = new AltoRouter();
	$router->setBasePath('/rooter_test');

	$router->map('GET','/', '/', 'base');
	$router->map('GET','/accueil', 'accueil', 'accueil');
	$router->map('GET|POST','/contact', "contact","contact");
	$router->map('GET|POST','/detail', "detail","detail");
	$router->map('GET|POST','/details/[i:id]', "DetailsID","detailsID");
	$router->map('GET|POST','/produits', "produits","produits");
	$router->map('GET|POST','/produits/[i:id]', 'produits#id', 'produits#id');
	$router->map('GET|POST','/articles', "articles","articles");
	$router->map('GET|POST','/articles/[i:id]', 'articles#id',"articles#id");
	$router->map('GET|POST','/articles/[i:id]/[delete|update:action]', 'articlesController#doAction', 'articles_do');
	$router->map('GET|POST','/validation','validation','validation');
	// match current request
	$match = $router->match();

	if($match["target"] === "produits"){
		require 'src/products.php';
	}elseif($match["target"] === "articles"){
		require 'src/articles.php';
	}elseif($match["target"] === "contact"){
		require 'src/contact.php';
	}elseif($match["target"] === "detail"){
		require 'src/showDetailsProduct.php';
	}elseif($match["target"] === "accueil"){
		require 'src/home.php';
	}elseif($match["target"]=== "validation"){
	    require 'src/rep_contact.php';
    }else{
	    require'src/404.php';
    }

	//dump( $router->getRoutes() );
	//dump( $match['target'] );
	//dump( $match['params'] );
	//dump( $match['name'] );

	require 'src/elements/footer.php';



