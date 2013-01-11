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

How to use
==========

All the magical of this bundle is located in the filter manager.
An abstract filter manager is provided, but also an entity abstract filter manager
which is able to manage all our doctrine2 entities filters.

![Filter Form UML schema](https://github.com/IDCI-Consulting/FilterFormBundle/blob/master/Resources/doc/idci-form-filter-bundle.png)

Create our own filter manager and filters
=========================================

In order to use this bundle, you have to extend some existing classes.
For instance, we will make a filter for a News entity :

// TODO : inset news UML schema

We have to create a NewsFilterManager (which is extending EntityAbstractFilterManager)
which is agregating 2 filters (that's just an example!) :
* AuthorFilter : allow to filter on author name
* TitleFilter : allow to filter on news title

The first kind of filter which is interesting us for the author is a RelationFieldEntityAbstractFilter,
which can select and filter on a join table (Author in our case).
We can also use a SelectRelationFieldEntityAbstractFilter which inherits the
first one but display data as a <select> html output.

In one hand we have to build our filters :

    <?php

    namespace MyApp\Bundle\MyBundle\Form\Filter;

    use IDCI\Bundle\FilterFormBundle\Form\Filter\SelectRelationFieldEntityAbstractFilter;

    class AuthorFilter extends SelectRelationFieldEntityAbstractFilter
    {
        // entities to retrieve
        public function getEntityClassName() { return "MyAppMyBundle:Author"; }

        // relation field name, in our case : author
        public function getEntityFieldName() { return "author"; }

        // filter label
        public function getFilterFormLabel() { return "Author"; }

        // filter name
        public function getFilterName() { return "news_author"; }
    }

The second filter we can use is a TextFieldEntityAbstractFilter, which can filter
on a full-text search :

    <?php

    namespace MyApp\Bundle\MyBundle\Form\Filter;

    use IDCI\Bundle\FilterFormBundle\Form\Filter\TextFieldEntityAbstractFilter;

    class TitleFilter extends TextFieldEntityAbstractFilter
    {
        public function getEntityClassName() { return "MyAppMyBundle:News"; }

        public function getEntityFieldName() { return "title"; }

        public function getFilterFormLabel() { return "Title"; }

        public function getFilterName() { return "news_title"; }
    }

On the other hand, we have to create the news filter manager, which will agregate our filters.
Our NewsFilterManager must look like this :

    <?php

    namespace MyApp\Bundle\MyBundle\Form\FilterManager;

    use IDCI\Bundle\FilterFormBundle\Form\FilterManager\EntityAbstractFilterManager;
    use MyApp\Bundle\MyBundle\Form\Filter\AuthorFilter;
    use MyApp\Bundle\MyBundle\Form\Filter\TitleFilter;

    class NewsFilterManager extends EntityAbstractFilterManager
    {
        public function buildFilters($options = array())
        {
            // We have to add the previous filters
            $this
                ->addFilter(new AuthorFilter())
                ->addFilter(new TitleFilter())
            ;
        }

        public function getEntityClassName()
        {
            return "MyApp\Bundle\MyBundle\Entity\News";
        }
    }

We provide some existing filters dealing with entities, you can have a look at the
bundle Filter directory.

How to use filter manager as service in controller
==================================================

First of all, you have to declare your own filter as a service in the service.yml in your bundle :

    services:
        my_filter_manager:
            class:     MyApp\Bundle\MyBundle\Form\FilterManager\MyFilterManager
            arguments:  [@service_container]

Then, you have to use it in the controller :

    public function filterAction(Request $request)
    {
        // retrieve the service
        $filterManager = $this->get('my_filter_manager');
        // create the filter form according to the filters given to the filter manager
        $filterForm    = $filterManager->createForm();

        // is data filtered ?
        if ($request->query->has($filterForm->getName())) {
            $filterForm->bindRequest($request);
        }

        $filteredNews = $filterManager->filter():

        // let's give all parameters to the view
        return array(
            'news'                   => $filteredNews,
            'filter_form'            => $filterForm->createView(),
            'form_action_route_name' => $request->get('_route'),
            'is_filtered'            => $filterManager->hasQueryingFilters()
        );
    }

Now we just have to display our filter form in the view :

    <form action="{{ path(form_action_route_name) }}" method="get">
        {{ form_widget(filter_form) }}
        <button type="submit">Filter</button>
    </form>

That'it. All the logic and the powerful of this bundle is located in the filter manager.
