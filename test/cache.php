<?php
class Cache {
	
	static function Get($class_name,$id){
		return Article::GetInstance($id);
	}
}
