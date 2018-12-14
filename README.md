SluggishRouter
==============

Base class for routers rendering URLs with slugs in ATK14 applications

It can handle "detail" URLs for models that have method ```getSlug($lang)``` and static method ```GetInstanceBySlug($slug,&$lang)```.

Basic usage
-----------

Router class:

    <?php
    // file: config/routers/articles_router.php
    class ArticlesRouter extends SluggishRouter {
      var $url_patterns_by_lang = array("en" => "article", "cs" => "clanek");
    }                                                                            

Loading router:

    <?php
    // file: config/routers/load.php
    Atk14Url::AddRouter("ArticlesRouter"); // the default namespace ("")
    Atk14Url::AddRouter("blog",AddRouter); // loading ArticlesRouter into namespace blog

In a template:

    {a controller="articles" action="detail" id=123}Here is the article{/a} 

Rendered HTML:

    <a href="/article/why-is-the-atk14-so-cool/">Here is the article</a>


Installation
------------

Use the Composer to install SluggishRouter.

    cd path/to/your/project/
    composer require atk14/sluggish-router dev-master

Licence
-------

SluggishRouter is free software distributed [under the terms of the MIT license](http://www.opensource.org/licenses/mit-license)
