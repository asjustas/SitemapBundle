SitemapBundle
=============

[![Build Status](https://scrutinizer-ci.com/g/tadcka/SitemapBundle/badges/build.png?b=master)](https://scrutinizer-ci.com/g/tadcka/SitemapBundle/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/tadcka/SitemapBundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/tadcka/SitemapBundle/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/tadcka/sitemap-bundle/v/stable.svg)](https://packagist.org/packages/tadcka/sitemap-bundle) [![Total Downloads](https://poser.pugx.org/tadcka/sitemap-bundle/downloads.svg)](https://packagist.org/packages/tadcka/sitemap-bundle) [![Latest Unstable Version](https://poser.pugx.org/tadcka/sitemap-bundle/v/unstable.svg)](https://packagist.org/packages/tadcka/sitemap-bundle) [![License](https://poser.pugx.org/tadcka/sitemap-bundle/license.svg)](https://packagist.org/packages/tadcka/sitemap-bundle)

Simple web page list manager.

## Installation

### Step 1: Download SitemapBundle using composer

Add SitemapBundle in your composer.json:

```js
{
    "require": {
        "tadcka/sitemap-bundle": "dev-master"
    }
}
```

Now tell composer to download the bundle by running the command:

``` bash
$ php composer.phar update tadcka/sitemap-bundle
```

### Step 2: Enable the bundle

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Tadcka\Bundle\SitemapBundle\TadckaSitemapBundle(),
    );
}
```

License
-------

This bundle is under the MIT license. See the complete license in the bundle:

Code License:
[Resources/meta/LICENSE](https://github.com/tadcka/SitemapBundle/blob/master/Resources/meta/LICENSE)

Authors
---------

The bundle was originally created by Tadas Gliaubicas. See the list of [contributors](https://github.com/tadcka/SitemapBundle/contributors).
