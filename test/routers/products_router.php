<?php
class ProductsRouter extends SluggishRouter {
	
	var $patterns = array(
		"en" => array("index" => "/products/", "detail" => "/product/<slug>/"),
		"cs" => array("index" => "/produkty/", "detail" => "/produkt/<slug>/"),
	);
}
