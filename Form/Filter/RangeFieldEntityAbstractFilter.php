<?php

namespace IDCI\Bundle\FilterFormBundle\Form\Filter;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @license: GPL
 *
 */
abstract class RangeFieldEntityAbstractFilter extends EntityAbstractFilter
{
    abstract public function getEntityFieldValueMin();
    abstract public function getEntityFieldValueMax();

    public function getFilterFormType()
    {
        return 'range';
    }

    public function getResultQueryBuilder($data, $qb, $name)
    {
        $qb
            ->andWhere($qb->expr()->between(
                sprintf('%s.%s', $name, $this->getEntityFieldName()),
                $data['min'],
                $data['max']
            ))
        ;

        return $qb;
    }
}
