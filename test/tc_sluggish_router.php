<?php
class TcSluggishRouter extends TcBase {

	function test(){
		$router = new ArticlesRouter();

		$router->controller = "articles";
		$router->action = "detail";
		$router->params["id"] = 123;
		$router->lang = "en";
		$this->assertEquals("/article/why-is-atk14-so-cool/",$router->build());

		$router->params["id"] = 123;
		$router->lang = "cs";
		$this->assertEquals("/clanek/proc-je-atk14-tak-skvele/",$router->build());

		$router->params["id"] = 333;
		$router->lang = "cs";
		$this->assertEquals(null,$router->build());

		
	}
}
