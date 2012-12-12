<?php

namespace IDCI\Bundle\FilterFormBundle\Form\FilterManager;

use IDCI\Bundle\FilterFormBundle\Form\AbstractFilter;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilder;
use IDCI\Bundle\FilterFormBundle\Form\Filter\EntityAbstractFilter;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @licence: GPL
 *
 */
abstract class EntityAbstractFilterManager extends AbstractFilterManager
{
    abstract public function getEntityClassName();

    protected function getRepository()
    {
        $em = $this->getContainer()->get("doctrine.orm.entity_manager");

        return  $em->getRepository($this->getEntityClassName());
    }

    protected function createQueryBuilder($name)
    {
        $repository = $this->getRepository();

        return $repository->createQueryBuilder($name);
    }

    /**
     * Get query builder to retrieve entities matching filters
     *
     * @return DoctrineQueryBuilder
     */
    public function getResultQueryBuilder()
    {
        $name = 'e';
        $qb = $this->createQueryBuilder($name);

        foreach($this->getQueryingFilters() as $field => $data) {
            if(count($data) > 0) {
                $filter = $this->getFilter($field);
                if($filter instanceof EntityAbstractFilter) {
                    $qb = $filter->filter(
                        $data, array('qb' => $qb, 'name' => $name)
                    );
                }
            }
        }

        return $qb;
    }

    /**
     * Get query to retrieve entities matching filters
     *
     * @return DoctrineQuery
     */
    public function getResultQuery()
    {
        $qb = $this->getResultQueryBuilder();

        return is_null($qb) ? $qb : $qb->getQuery();
    }

    /**
     * Get all entities matching filters
     *
     * @return array
     */
    public function getResult()
    {
        $q = $this->getResultQuery();

        return is_null($q) ? array() : $q->getResult();
    }

    public function runFilters()
    {
        return $this->getResult();
    }
}
