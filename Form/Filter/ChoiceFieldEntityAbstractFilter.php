<?php

namespace IDCI\Bundle\FilterFormBundle\Form\Filter;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @licence: GPL
 *
 */
abstract class ChoiceFieldEntityAbstractFilter extends EntityFieldAbstractFilter
{
    public function getFilterFormType()
    {
        return 'choice';
    }

    public function getFilterFormOptions()
    {
        return array(
            'label'         => $this->getFilterFormLabel(),
            'choices'       => $this->getEntityFieldValues(),
            'expanded'      => true,
            'multiple'      => true
        );
    }

    public function getEntityFieldValues()
    {
        $qb = $this->getQueryBuilder('f')
            ->select(sprintf('DISTINCT f.%s', $this->getEntityFieldName()))
        ;

        $ret = array();
        foreach($qb->getQuery()->getResult() as $result) {
            $v = $result[$this->getEntityFieldName()];
            if($v != null) {
                $ret[$v] = $v;
            }
        }

        return $ret;
    }

    public function getResultQueryBuilder($data, $qb, $name)
    {
        $column = sprintf('%s.%s', $name, $this->getEntityFieldName());
        $qb->andWhere($qb->expr()->in($column, $data));

        return $qb;
    }
}
