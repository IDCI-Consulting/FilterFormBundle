<?php

namespace IDCI\Bundle\FilterFormBundle\Form\Filter;

use IDCI\Bundle\FilterFormBundle\Form\Filter\RelationFieldEntityAbstractFilter;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @licence: GPL
 *
 */
abstract class JoinRelationFieldEntityAbstractFilter extends RelationFieldEntityAbstractFilter
{
    abstract public function getEntityJoinFieldName();
    
    public function getResultQueryBuilder($data, $qb, $name)
    {
        $ids = array();
        foreach($data as $object) {
            $ids[] = $object->getId();
        }

        $alias1 = $this->generateAlias($name, $this->getEntityJoinFieldName());
        $qb->leftJoin(
            sprintf('%s.%s', $name, $this->getEntityJoinFieldName()),
            $alias1
        );

        $alias2 = $this->generateAlias($this->getEntityJoinFieldName(), $this->getEntityFieldName());
        $qb->leftJoin(
            sprintf('%s.%s', $alias1, $this->getEntityFieldName()),
            $alias2
        );
        $column = sprintf('%s.id', $alias2);
        $qb->andWhere($qb->expr()->in($column, $ids));

        return $qb;
    }
}
