<?php

namespace IDCI\Bundle\FilterFormBundle\Form\Filter;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @licence: GPL
 *
 */
abstract class TextFieldEntityAbstractFilter extends EntityAbstractFilter
{
    public function getFilterFormType()
    {
        return 'text';
    }

    public function getResultQueryBuilder($data, $qb, $name)
    {
        $qb
            ->andWhere(sprintf('%s.%s = :data',
                $name,
                $this->getEntityFieldName()
            ))
            ->setParameter('data', $data)
        ;

        return $qb;
    }
}
