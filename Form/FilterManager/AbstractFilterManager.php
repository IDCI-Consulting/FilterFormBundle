<?php

namespace IDCI\Bundle\FilterFormBundle\Form\FilterManager;

use IDCI\Bundle\FilterFormBundle\Form\AbstractFilter;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilder;
use IDCI\Bundle\FilterFormBundle\Form\EventListener\QueringFilterSubscriber;


/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: GPL
 *
 */
abstract class AbstractFilterManager
{
    protected $container;
    protected $filterOptions;
    protected $form;
    protected $filters = array();
    protected $queryingFilters = array();

    /**
     * Constructor
     */
    public function __construct($container, $filterOptions = array())
    {
        $this->container = $container;
        $this->filterOptions = $filterOptions;
        $this->form = null;
    }

    /**
     * getContainer
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * setFilterOptions
     */
    public function setFilterOptions($filterOptions)
    {
         $this->filterOptions = $filterOptions;
    }

    /**
     * getFilterOptions
     */
    public function getFilterOptions()
    {
        return $this->filterOptions;
    }

    /**
     * setForm
     */
    public function setForm($form)
    {
        $this->form = $form;
    }

    /**
     * getForm
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * hasFilter
     *
     * @param string $name
     * @return boolean
     */
    public function hasFilter($name)
    {
        return isset($this->filters[$name]);
    }

    /**
     * getFilter
     *
     * @param string $name
     * @return AbstractFilter
     */
    public function getFilter($name)
    {
        return $this->filters[$name];
    }

    /**
     * getFilters
     *
     * @return array
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * addFilter
     *
     * @param AbstractFilter $filter
     * @param boolean $replace
     * @return AbstractFilterManager The current filter manager
     */
    public function addFilter($filter, $replace = false)
    {
        if($this->hasFilter($filter->getFilterName()) && !$replace) {
            throw new \Exception(sprintf('%s: The filter %s is already present',
                get_class($this),
                $filter->getFilterName()
            ));
        }

        $filter->setContainer($this->getContainer());
        $this->filters[$filter->getFilterName()] = $filter;

        return $this;
    }

    /**
     * removeFilter
     *
     * @param string $name
     * @return AbstractFilterManager The current filter manager
     */
    public function removeFilter($name)
    {
        if(!$this->hasFilter($name)) {
            throw new \Exception(sprintf('%s: Can\'t remove a missing filter %s',
              get_class($this),
              $name
            ));
        }

        unset($this->filters[$name]);

        return $this;
    }

    /**
     * setQueryingFilters
     */
    public function setQueryingFilters($queryingFilters)
    {
         $this->queryingFilters = $queryingFilters;
    }

    /**
     * getQueryingFilters
     */
    public function getQueryingFilters()
    {
        return $this->queryingFilters;
    }

    /**
     * hasQueryingFilters
     */
    public function hasQueryingFilters()
    {
        return count($this->getQueryingFilters()) > 0;
    }

    /**
     * buildFilters
     */
    abstract public function buildFilters($options = array());

    /**
     * runFilters
     *
     * @return array
     */
    abstract public function runFilters();

    /**
     * filter
     *
     * @return array
     */
    public function filter()
    {
        return $this->runFilters();
    }

    /**
     * getFormName
     *
     * @return string
     */
    public function getFormName()
    {
        return 'filter_form';
    }

    /**
     * getFormBuilder
     *
     * @return FormBuilderInterface The form builder
     */
    protected function getFormBuilder()
    {
        $this->buildFilters($this->getFilterOptions());

        return $this->container->get('form.factory')->createNamedBuilder(
            $this->getFormName(),
            'form',
            null,
            array('csrf_protection' => false)
        );
    }

    /**
     * createFormBuilder
     *
     * @return FormBuilderInterface The form builder
     */
    protected function createFormBuilder()
    {
        $builder = $this->getFormBuilder();

        // To add quering filter subscriber
        $subscriber = new QueringFilterSubscriber(
            $builder->getFormFactory(),
            $this
        );
        $builder->addEventSubscriber($subscriber);

        // To build the filter form
        foreach($this->getFilters() as $filter) {
            $builder->add(
                $filter->getFilterName(),
                $filter->getFilterFormType(),
                $filter->getFilterFormOptions()
            );
        }

        return $builder;
    }

    /**
     * createForm
     *
     * @return Form
     */
    public function createForm()
    {
        $this->setForm($this->createFormBuilder()->getForm());

        return $this->getForm();
    }
}
