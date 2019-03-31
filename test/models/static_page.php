<?php
class StaticPage extends Model {
	
	static $INSTANCES = array(
		111 => array("en" => "about-us", "cs" => "o-nas"),
		222 => array("en" => "contact-data", "cs" => "kontakty"),
	);
}
