<?php
class GenericProductsRouter extends SluggishRouter {
	
	var $patterns = array(
		"<lang>" => array("index" => "/<lang>/products/", "detail" => "/<lang>/product/<slug>/"),
	);
}
