<?php
class TcSluggishRouter extends TcBase {

	function test(){
		// Building URI
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

		// Recognize
		$router = new ArticlesRouter();
		$this->assertEquals(null,$router->params["id"]);
		$this->assertEquals("",$router->lang);
		//
		$router->recognize("/article/why-is-atk14-so-cool/");
		$this->assertEquals("en",$router->lang);
		$this->assertEquals(123,$router->params["id"]);

		$router = new ArticlesRouter();
		$this->assertEquals(null,$router->params["id"]);
		$this->assertEquals("",$router->lang);
		//
		$router->recognize("/clanek/dalsi-skvely-clanek/");
		$this->assertEquals("cs",$router->lang);
		$this->assertEquals(222,$router->params["id"]);

		$router = new ArticlesRouter();
		$this->assertEquals(null,$router->params["id"]);
		$this->assertEquals("",$router->lang);
		//
		$router->recognize("/article/not-really-an-article/");
		$this->assertEquals("",$router->lang);
		$this->assertEquals(null,$router->params["id"]);
	}
}
