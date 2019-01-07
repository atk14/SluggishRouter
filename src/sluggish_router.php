<?php
/**
 * Base router for routers rendering URLs with slugs
 *
 * It can handle "detail" URLs.
 *
 * Usage:
 *
 * Router class
 *	// file: config/routers/articles_router.php
 * 	class ArticlesRouter extends SluggishRouter{
 *		var $patterns = [
 *			"en" => "/article/<slug>/",
 *			"cs" => "/clanek/<slug>/",
 *			"sk" => "/clanok/<slug>/",
 *		];
 * 	}
 *
 * Enable the router
 *	// file: config/routers/load.php
 *	Atk14Url::AddRouter("ArticlesRouter");
 *
 * In a template
 * 	{a controller="articles" action="detail" id=123}Here is the article{/a}
 *
 * Rendered HTML
 * 	<a href="/article/why-is-the-atk14-so-cool/">Here is the article</a>
 *
 */
class SluggishRouter extends Atk14Router{

	var $patterns = array(); // .e.g., array("en" => "/article/<slug>/"), both keys and values must be unique
	var $model_class_name = null; // .e.g., "Article", by default it is determined automatically
	var $target_controller_name = null; // .e.g, "articles", by default it is determined automatically
	protected $compiled_patterns = array();
	
	function __construct(){
		global $ATK14_GLOBAL;

		$cn = new String4(get_class($this)); // "ArticlesRouter"
		$cn = $cn->gsub('/Router$/',''); // "Articles"

		if(is_null($this->model_class_name)){
			$this->model_class_name = (string)$cn->singularize(); // "Article"
		}

		if(is_null($this->target_controller_name)){
			$this->target_controller_name = (string)$cn->underscore(); // "articles"
		}

		if(!$this->patterns){
			$lang = $ATK14_GLOBAL->getDefaultLang();
			$this->patterns = array(
				"$lang" => sprintf("/%s/<slug>/",(string)$cn->underscore()->singularize()->replace("_","-")) // "en" => "/article/<slug>/"
			);
		}

		$patterns_rev = array_combine(array_values($this->patterns),array_keys($this->patterns));
		if(sizeof($this->patterns)!=sizeof($patterns_rev)){
			throw new Exception(get_class($this).': non-unique values in $patterns');
		}

		$this->compiled_patterns = array();
		foreach($this->patterns as $lang => $pattern){
			$pattern = strtr($pattern,array(
				'/' => "\\/",
				'.' => "\\.",
				'<slug>' => '(?P<slug>[a-z0-9-]+)',
			));
			$pattern = "/^$pattern$/"; // e.g. /^\/article\/(?P<slug>[a-z0-9-]+)\/$/
			$this->compiled_patterns[$lang] = $pattern;
		}

		parent::__construct();
	}

	function recognize($uri){
		foreach($this->compiled_patterns as $lang => $pattern){
			if(preg_match($pattern,$uri,$matches)){
				$class = $this->model_class_name;
				if($c = $class::GetInstanceBySlug($matches["slug"],$lang)){
					$this->action = "detail";
					$this->controller = $this->target_controller_name;
					$this->params["id"] = $c->getId();
					$this->lang = $lang;
					return;
				}
				return;
			}
		}
	}

	function build(){
		$lang = (string)$this->lang;
		if($this->controller!=$this->target_controller_name || $this->action!="detail" || !isset($this->patterns[$lang])){ return; }

		$class = $this->model_class_name;
		if($c = Cache::Get($class,$this->params->getInt("id"))){
			$this->params->del("id");
			$pattern = $this->patterns[$lang];
			return str_replace('<slug>',$c->getSlug($lang),$pattern);
		}
	}
}
