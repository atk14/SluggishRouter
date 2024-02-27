<?php
class BlogsRouter extends SluggishRouter {

	var $patterns = array(
		"en" => "blog",
		"cs" => "blogisek",
	);

	var $model_class_name = "Article";
}
