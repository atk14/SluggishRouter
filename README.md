SluggishRouter
==============

Base class for ATK14 routers generating nice looking URLs with slugs

It can handle "detail" URLs for models that have method ```getSlug($lang)``` and static method ```GetInstanceBySlug($slug,&$lang)```. You can find both in the [Atk14Catalog](http://catalog.atk14.net/).

Basic usage
-----------

Router class:

    <?php
    // file: config/routers/articles_router.php
    class ArticlesRouter extends SluggishRouter {

      var $patterns = [
        "en" => ["index" => "/articles/", "detail" => "/articles/<slug>/"],
        "cs" => ["index" => "/clanky/", "detail" => "/clanky/<slug>/"],
        "sk" => ["index" => "/sk/clanky/", "detail" => "/sk/clanky/<slug>/"],
      ];
      
      // var $model_class_name = "Article"; // by default determined automatically according to the router's class name
      // var $target_controller_name = "articles"; // by default determined automatically according to the router's class name
    }

Loading router:

    <?php
    // file: config/routers/load.php
    Atk14Url::AddRouter("ArticlesRouter"); // the default namespace ("")
    Atk14Url::AddRouter("blog","ArticlesRouter"); // loading ArticlesRouter also into namespace blog

In a template:

    {a controller="articles" action="detail" id=123}Here is the article{/a}<br>
    {a controller="articles" action="index"}Show all articles{/a}

Rendered HTML:

    <a href="/articles/why-is-the-atk14-so-cool/">Here is the article</a><br>
    <a href="/articles/">Show all articles</a>

Fallback route
--------------

A fallback route for all the unlisted languages can be specified using the asterisk symbol.

    <?php
    // file: config/routers/articles_router.php
    class ArticlesRouter extends SluggishRouter {
      var $patterns = [
        "*" => ["index" => "/<lang>/articles/", "detail" => "/<lang>/articles/<slug>/"],
      ];
    }

Installation
------------

Use the Composer to install SluggishRouter.

    cd path/to/your/project/
    composer require atk14/sluggish-router

Testing
-------

    composer update --dev
    cd test
    ../vendor/bin/run_unit_tests

Licence
-------

SluggishRouter is free software distributed [under the terms of the MIT license](http://www.opensource.org/licenses/mit-license)

[//]: # ( vim: set ts=2 et: )
