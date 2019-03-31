<?php
class TcSluggishRouter extends TcBase {

	function test_ArticlesRouter(){
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

		$router->action = "index";
		$router->lang = "en";
		$this->assertEquals(null,$router->build());

		$router->action = "index";
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

		// Recognize index action - in the ArticlesRouter there are no patterns for index action
		$router = new ArticlesRouter();
		$router->recognize("/articles/");
		$this->assertEquals("",$router->lang);
		$this->assertEquals("",$router->controller);
		$this->assertEquals("",$router->action);

		$router = new ArticlesRouter();
		$router->recognize("/clanky/");
		$this->assertEquals("",$router->lang);
		$this->assertEquals("",$router->controller);
		$this->assertEquals("",$router->action);
	}

	function test_ProductsRouter(){
		// Building URI
		$router = new ProductsRouter();

		$router->controller = "products";
		$router->action = "detail";
		$router->params["id"] = 11;
		$router->lang = "en";
		$this->assertEquals("/product/atk14-book/",$router->build());

		$router->params["id"] = 11;
		$router->lang = "cs";
		$this->assertEquals("/produkt/atk14-book/",$router->build());

		$router->params["id"] = 333;
		$router->lang = "cs";
		$this->assertEquals(null,$router->build());

		$router->action = "index";
		$router->lang = "en";
		$this->assertEquals("/products/",$router->build());

		$router->action = "index";
		$router->lang = "cs";
		$this->assertEquals("/produkty/",$router->build());

		// Recognize
		$router = new ProductsRouter();
		$this->assertEquals(null,$router->params["id"]);
		$this->assertEquals("",$router->lang);
		//
		$router->recognize("/product/atk14-book/");
		$this->assertEquals("en",$router->lang);
		$this->assertEquals(11,$router->params["id"]);

		$router = new ProductsRouter();
		$router->recognize("/produkt/atk14-book/");
		$this->assertEquals("cs",$router->lang);
		$this->assertEquals(11,$router->params["id"]);

		$router = new ProductsRouter();
		$router->recognize("/produkt/vesely-zeleny-hrnecek/");
		$this->assertEquals("cs",$router->lang);
		$this->assertEquals(222,$router->params["id"]);

		$router = new ProductsRouter();
		$router->recognize("/products/not-really-a-product/");
		$this->assertEquals("",$router->lang);
		$this->assertEquals(null,$router->params["id"]);

		// Recognize index action
		$router = new ProductsRouter();
		$router->recognize("/products/");
		$this->assertEquals("en",$router->lang);
		$this->assertEquals("products",$router->controller);
		$this->assertEquals("index",$router->action);

		$router = new ProductsRouter();
		$router->recognize("/produkty/");
		$this->assertEquals("cs",$router->lang);
		$this->assertEquals("products",$router->controller);
		$this->assertEquals("index",$router->action);

		$router = new ProductsRouter();
		$router->recognize("/articles/");
		$this->assertEquals("",$router->lang);
		$this->assertEquals("",$router->controller);
		$this->assertEquals("",$router->action);
	}

	function test_StaticPagesRouter(){
		// Building - in the StaticPagesRouter there are only paths for the default language
		$router = new StaticPagesRouter();

		$router->controller = "static_pages";
		$router->action = "detail";
		$router->params["id"] = 111;
		$router->lang = "en";
		$this->assertEquals("/static-pages/about-us/",$router->build());

		$router->params["id"] = 111;
		$router->lang = "cs";
		$this->assertEquals(null,$router->build());

		$router->params["id"] = 222;
		$router->lang = "en";
		$this->assertEquals("/static-pages/contact-data/",$router->build());

		$router->params["id"] = 222;
		$router->lang = "cs";
		$this->assertEquals(null,$router->build());

		// Recognize
		$router = new StaticPagesRouter();
		$router->recognize("/static-pages/about-us/");
		$this->assertEquals("en",$router->lang);
		$this->assertEquals("static_pages",$router->controller);
		$this->assertEquals("detail",$router->action);
		$this->assertEquals(111,$router->params["id"]);

		$router = new StaticPagesRouter();
		$router->recognize("/static-pages/contact-data/");
		$this->assertEquals("en",$router->lang);
		$this->assertEquals("static_pages",$router->controller);
		$this->assertEquals("detail",$router->action);
		$this->assertEquals(222,$router->params["id"]);

		$router = new StaticPagesRouter();
		$router->recognize("/static-pages/nonsence/");
		$this->assertEquals(null,$router->lang);
		$this->assertEquals(null,$router->controller);
		$this->assertEquals(null,$router->action);
		$this->assertEquals(null,$router->params["id"]);

		// Recognize index action
		$router = new StaticPagesRouter();
		$router->recognize("/static-pages/");
		$this->assertEquals("en",$router->lang);
		$this->assertEquals("static_pages",$router->controller);
		$this->assertEquals("index",$router->action);
		$this->assertEquals(null,$router->params["id"]);
	}
}
