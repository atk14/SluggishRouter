<?php
class GenericArticlesRouter extends SluggishRouter {

	var $patterns = array(
		"*" => "/<lang>/article/<slug>/",
	);
}
