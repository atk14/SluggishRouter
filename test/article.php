<?php
class Article {

	static $INSTANCES = array(
		123 => array("en" => "why-is-atk14-so-cool", "cs" => "proc-je-atk14-tak-skvele"),
		222 => array("en" => "another-fine-article", "cs" => "dalsi-skvely-clanek"),
	);

	function __construct($id){
		$this->id = $id;
		$this->slugs = self::$INSTANCES[$id];
	}

	static function GetInstance($id){
		if(!isset(self::$INSTANCES[$id])){
			return;
		}
		return new Article($id);
	}

	static function GetInstanceBySlug($slug,&$lang){
		foreach(self::$INSTANCES as $id => $slugs){
			foreach($slugs as $l => $s){
				if($slug==$s){
					$lang = $l;
					$article = new Article($id,$slugs);
					return $article;
				}
			}
		}
	}

	function getId(){
		return $this->id;
	}

	function getSlug($lang = null){
		global $ATK14_GLOBAL;
		if(!$lang){ $lang = $ATK14_GLOBAL->getDefaultLang(); }
		return $this->slugs[$lang];
	}
}
