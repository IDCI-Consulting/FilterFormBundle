<?php

namespace IDCI\Bundle\FilterFormBundle\Form\Filter;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @licence: GPL
 *
 */
abstract class RelationFieldEntityAbstractFilter extends EntityAbstractFilter
{
    public function getFilterFormType()
    {
        return 'entity';
    }

    public function getFilterFormOptions()
    {
        return array(
            'label'         => $this->getFilterFormLabel(),
            'class'         => $this->getEntityClassName(),
            'query_builder' => $this->getQueryBuilder(),
            'required'      => true,
            'expanded'      => true,
            'multiple'      => true
        );
    }

    public function getResultQueryBuilder($data, $qb, $name)
    {
        $ids = array();
        foreach($data as $object) {
            $ids[] = $object->getId();
        }

        $qb->leftJoin(
            sprintf('%s.%s', $name, $this->getEntityFieldName()),
            $this->getEntityFieldName()
        );
        $column = sprintf('%s.id', $this->getEntityFieldName());
        $qb->andWhere($qb->expr()->in($column, $ids));

        return $qb;
    }
}
