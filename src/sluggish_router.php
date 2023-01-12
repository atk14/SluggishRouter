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
 *	class ArticlesRouter extends SluggishRouter{
 *		var $patterns = [
 *			"en" => "/article/<slug>/",
 *			"cs" => "/clanek/<slug>/",
 *			"sk" => "/clanok/<slug>/",
 *		];
 *	}
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

			// route for the default lang
			$this->patterns["$lang"] = array(
				"index" => sprintf("/%s/",$cn->underscore()->replace("_","-")->toString()), // "/articles/"
				"detail" => sprintf("/%s/<slug>/",$cn->underscore()->replace("_","-")->toString()), // "/articles/<slug>/"
			);

			/*
			// routes for all the other langs
			// (not sure if this is desired behaviour)
			$this->patterns["<lang>"] = array(
				"index" => sprintf("/<lang>/%s/",$cn->underscore()->replace("_","-")->toString()), // "/<lang>/articles/"
				"detail" => sprintf("/<lang>/%s/<slug>/",$cn->underscore()->replace("_","-")->toString()), // "/<lang>/articles/<slug>/"
			);
			*/
		}

		if(isset($this->patterns["<lang>"])){
			foreach($ATK14_GLOBAL->getSupportedLangs() as $lang){
				if(isset($this->patterns[$lang])){ continue; }
				$this->patterns[$lang] = $this->_replace_lang($this->patterns["<lang>"],$lang);
			}
			unset($this->patterns["<lang>"]);
		}

		foreach($this->patterns as $lang => $pattern_ar){
			if(!is_array($pattern_ar)){
				$pattern_ar = array("detail" => $pattern_ar);
				$this->patterns[$lang] = $pattern_ar;
			}
		}

		/*
		$patterns_rev = array_combine(array_values($this->patterns),array_keys($this->patterns));
		if(sizeof($this->patterns)!=sizeof($patterns_rev)){
			throw new Exception(get_class($this).': non-unique values in $patterns');
		} */

		$this->compiled_patterns = array();
		foreach($this->patterns as $lang => $pattern_ar){
			foreach($pattern_ar as $action => $pat){
				$pat = preg_replace('/\/$/','/?',$pat); // "/articles/" -> "/articles/?"
				$pat = strtr($pat,array(
					'/' => "\\/",
					'.' => "\\.",
					'<slug>' => '(?P<slug>[a-z0-9-]+)',
				));
				$pattern_ar[$action] = "/^$pat$/"; // e.g. /^\/article\/(?P<slug>[a-z0-9-]+)\/?$/
			}
			$this->compiled_patterns[$lang] = $pattern_ar;
		}

		//var_dump($this->patterns);
		//var_dump($this->compiled_patterns); exit;

		parent::__construct();
	}

	function recognize($uri){
		foreach($this->compiled_patterns as $lang => $pattern_ar){
			foreach($pattern_ar as $action => $pat){
				if(preg_match($pat,$uri,$matches)){

					if(isset($matches["slug"])){
						$class = $this->model_class_name;
						if(!($c = $class::GetInstanceBySlug($matches["slug"],$lang))){
							return;
						}
						$this->params["id"] = $c->getId();
					}

					$this->action = $action;
					$this->controller = $this->target_controller_name;
					$this->lang = $lang;

					return;
				}
			}
		}
	}

	function build(){
		$lang = (string)$this->lang;
		$action = (string)$this->action;

		if($this->controller!=$this->target_controller_name || !isset($this->patterns[$lang]) || !isset($this->patterns[$lang][$action])){ return; }

		$pattern = $this->patterns[$lang][$action];

		if(strpos($pattern,"<slug>")!==false){
			$class = $this->model_class_name;
			if($c = Cache::Get($class,$this->params->getInt("id"))){
				$this->params->del("id");
				return str_replace('<slug>',$c->getSlug($lang),$pattern); // "/article/why-this-is-so-powerful/"
			}
			return;
		}

		return $pattern; // "/articles/"
	}

	function _replace_lang($route,$lang){
		if(is_array($route)){
			foreach($route as $k => $v){
				$route[$k] = str_replace("<lang>",$lang,$route[$k]);
			}
		}else{
			$route = str_replace("<lang>",$lang,$route);
		}
		return $route;
	}
}
