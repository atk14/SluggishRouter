<?php
class Atk14Router {

	function __construct(){
		$this->controller = "";
		$this->action = "";
		$this->params = new Dictionary();

	}
}

require(__DIR__ . "/../src/sluggish_router.php");
require(__DIR__ . "/../vendor/autoload.php");

require(__DIR__ . "/articles_router.php");
require(__DIR__ . "/article.php");
require(__DIR__ . "/cache.php");

interface IAtk14Global {
	function getValue($key);
	function getLang();
}

$ATK14_GLOBAL = Mockery::mock("Atk14Global");
$ATK14_GLOBAL->shouldReceive("getDefaultLang")->andReturn("en");
