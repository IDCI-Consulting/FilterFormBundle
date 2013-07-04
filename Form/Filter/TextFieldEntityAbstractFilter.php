<?php

namespace IDCI\Bundle\FilterFormBundle\Form\Filter;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @license: GPL
 *
 */
abstract class TextFieldEntityAbstractFilter extends EntityFieldAbstractFilter
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
