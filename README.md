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
        "en" => "/article/<slug>/",
        "cs" => "/clanek/<slug>/",
        "sk" => "/clanok/<slug>/"
      ];
      
      // var $model_class_name = "Article"; // by default determined automatically according to the router's class name
      // var $target_controller_name = "articles"; // by determined determined automatically according to the router's class name
    }                                                                            

Loading router:

    <?php
    // file: config/routers/load.php
    Atk14Url::AddRouter("ArticlesRouter"); // the default namespace ("")
    Atk14Url::AddRouter("blog","ArticlesRouter"); // loading ArticlesRouter also into namespace blog

In a template:

    {a controller="articles" action="detail" id=123}Here is the article{/a} 

Rendered HTML:

    <a href="/article/why-is-the-atk14-so-cool/">Here is the article</a>


Installation
------------

Use the Composer to install SluggishRouter.

    cd path/to/your/project/
    composer require atk14/sluggish-router

Licence
-------

SluggishRouter is free software distributed [under the terms of the MIT license](http://www.opensource.org/licenses/mit-license)
