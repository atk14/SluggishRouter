<?php
class Model {

	static $INSTANCES = array();

	function __construct($id){
		$class = get_called_class(); // e.g.  "Article"
		$this->id = $id;
		$this->slugs = $class::$INSTANCES[$id];
	}

	static function GetInstance($id){
		$class = get_called_class(); // e.g.  "Article"
		if(!isset($class::$INSTANCES[$id])){
			return;
		}
		$class = get_called_class(); // e.g.  "Article"
		return new $class($id);
	}

	static function GetInstanceBySlug($slug,&$lang){
		$class = get_called_class(); // e.g.  "Article"
		foreach($class::$INSTANCES as $id => $slugs){
			if($lang && isset($slugs[$lang]) && $slug==$slugs[$lang]){
				$object = new $class($id,$slugs);
				return $object;
			}
			foreach($slugs as $l => $s){
				if($slug==$s){
					$lang = $l;
					$object = new $class($id,$slugs);
					return $object;
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
