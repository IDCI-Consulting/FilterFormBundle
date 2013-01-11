<?php

namespace IDCI\Bundle\FilterFormBundle\Form\Filter;

use IDCI\Bundle\FilterFormBundle\Form\Filter\EntityAbstractFilter;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @licence: GPL
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
            ->andWhere(sprintf('%s.%s > :min and %s.%s < :max',
                $name,
                $this->getEntityFieldName(),
                $name,
                $this->getEntityFieldName()
            ))
            ->setParameters(array(
                'min', $data['min'],
                'max', $data['max'],
            ));
        ;

        return $qb;
    }
}
