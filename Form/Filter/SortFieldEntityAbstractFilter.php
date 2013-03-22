<?php

namespace IDCI\Bundle\FilterFormBundle\Form\Filter;


/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @licence: GPL
 *
 */
abstract class SortFieldEntityAbstractFilter extends EntityFieldAbstractFilter
{
    const ORDER_ASC = "ASC";
    const ORDER_DESC = "DESC";
    
    private static $sortFilterEnabled = 0;

    public function getChoices()
    {
        return array(
            self::ORDER_ASC  => 'Ascending',
            self::ORDER_DESC => 'Descending',
        );
    }
    
    public function getDefaultOrder() { return self::ORDER_ASC; }

    public function getFilterFormType()
    {
        return 'choice';
    }
    
    public function getFilterFormOptions() {
        $filterFormOptions = parent::getFilterFormOptions();

        return array_merge($filterFormOptions, array(
            'multiple' => false,
            'expanded' => true,
            'choices'  => $this->getChoices(),
            'required' => false,
            'data'     => $this->getDefaultOrder()
        ));
    }

    public function getResultQueryBuilder($data, $qb, $name)
    {
        $order = $data ? $data : $this->getDefaultOrder();
        if(self::$sortFilterEnabled == 0) {
            $qb->orderBy(sprintf('%s.%s',
                    $name,
                    $this->getEntityFieldName()
                ),
                $order
            );
        } else {
            $qb->addOrderBy(sprintf('%s.%s',
                    $name,
                    $this->getEntityFieldName()
                ),
                $order
            );
        }
        self::$sortFilterEnabled++;

        return $qb;
    }
}
