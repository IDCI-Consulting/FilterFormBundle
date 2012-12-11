FilterFormBundle
================

Symfony2 filter form bundle


Installation
============

To install this bundle please follow the next steps:

First add the dependency in your `composer.json` file:

    "require": {
        ...
        "idci/filter-form-bundle": "dev-master"
    },

Then install the bundle with the command:

    php composer update

Enable the bundle in your application kernel:

    <?php
    // app/AppKernel.php

    public function registerBundles()
    {
        $bundles = array(
            // ...
            new IDCI\Bundle\FilterFormBundle\IDCIFilterFormBundle(),
        );
    }

Now the Bundle is installed.