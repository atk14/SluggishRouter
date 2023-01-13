<?php
class GenericProductsRouter extends SluggishRouter {
	
	var $patterns = array(
		"*" => array("index" => "/<lang>/products/", "detail" => "/<lang>/product/<slug>/"),
	);
}
