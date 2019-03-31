<?php
class Cache {
	
	static function Get($class_name,$id){
		return $class_name::GetInstance($id);
	}
}
