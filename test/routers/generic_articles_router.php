<?php
class GenericArticlesRouter extends SluggishRouter {

	var $patterns = array(
		"<lang>" => "/<lang>/article/<slug>/",
	);
}
