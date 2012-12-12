<?php

namespace IDCI\Bundle\FilterFormBundle\Form\Filter;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @licence: GPL
 *
 */
abstract class AbstractFilter
{
    protected $options;
    protected $container;

    public function __construct($options = array(), $container = null)
    {
        $this->options = $options;
        $this->container = $container;
    }

    public function __toString()
    {
        return $this->getFilterName();
    }

    public function setContainer($container)
    {
        $this->container = $container;
    }

    public function getContainer()
    {
        return $this->container;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function getOption($name)
    {
        return isset($this->options[$name]) ? $this->options[$name] : null;
    }

    public function filter($data, $params = array()) { return $data; }
    public function getDefaultDataFilters() { return null; }

    abstract public function getFilterFormType();
    abstract public function getFilterName();
    abstract public function getFilterFormOptions();
}
