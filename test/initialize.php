<?php
class Atk14Router {

	function __construct(){
		$this->controller = "";
		$this->action = "";
		$this->lang = "";
		$this->params = new Dictionary();
	}
}

require(__DIR__ . "/../src/sluggish_router.php");
require(__DIR__ . "/../vendor/autoload.php");

require(__DIR__ . "/models/model.php");
require(__DIR__ . "/models/article.php");
require(__DIR__ . "/models/product.php");
require(__DIR__ . "/models/static_page.php");

require(__DIR__ . "/routers/articles_router.php");
require(__DIR__ . "/routers/products_router.php");
require(__DIR__ . "/routers/static_pages_router.php");
require(__DIR__ . "/routers/generic_articles_router.php");
require(__DIR__ . "/routers/generic_products_router.php");

require(__DIR__ . "/cache.php");

interface IAtk14Global {
	function getValue($key);
	function getLang();
}

$ATK14_GLOBAL = Mockery::mock("Atk14Global");
$ATK14_GLOBAL->shouldReceive("getDefaultLang")->andReturn("en");
$ATK14_GLOBAL->shouldReceive("getSupportedLangs")->andReturn(array("en","cs","sk"));
