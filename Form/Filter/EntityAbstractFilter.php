<?php

namespace IDCI\Bundle\FilterFormBundle\Form\Filter;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @licence: GPL
 *
 */
abstract class EntityAbstractFilter extends AbstractFilter
{
    public function getFilterFormOptions()
    {
        return array(
            'label' => $this->getFilterFormLabel(),
        );
    }

    public function getRepository()
    {
        $em = $this->getContainer()->get("doctrine.orm.entity_manager");

        return $em->getRepository($this->getEntityClassName());
    }

    public function getQueryBuilder($name = 'f')
    {
        return $this->getRepository()->createQueryBuilder($name);
    }

    public function getQuery()
    {
        return $this->getQueryBuilder()->getQuery();
    }

    public function getDefaultDataFilters()
    {
        return $this->getQuery()->getResult();
    }

    public function filter($data, $params = array())
    {
        // TODO: Throw exception if params missing (qb and name)
        return $this->getResultQueryBuilder($data, $params['qb'], $params['name']);
    }

    abstract public function getResultQueryBuilder($data, $qb, $name);

    abstract public function getFilterFormLabel();
    abstract public function getEntityClassName();
}
