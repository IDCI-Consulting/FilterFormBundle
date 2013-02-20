<?php

namespace IDCI\Bundle\FilterFormBundle\Form\Filter;


/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @licence: GPL
 *
 */
abstract class OrderByEntityAbstractFilter extends EntityAbstractFilter
{
    const ORDER_ASC = "ASC";
    const ORDER_DESC = "DESC";
    
    abstract public function getAvailableFields();

    public function getAvailableOrders()
    {
        return array(
            self::ORDER_ASC  => 'Ascending',
            self::ORDER_DESC => 'Descending',
        );
    }

    public function getDefaultOrder() { return self::ORDER_ASC; }

    public function getFilterFormType()
    {
        return 'orderby';
    }

    public function getResultQueryBuilder($data, $qb, $name)
    {
        $order = $data['order'] ? $data['order'] : $this->getDefaultOrder();
        $qb->orderBy(sprintf('%s.%s',
                $name,
                $data['field']
            ),
            $order
        );

        return $qb;
    }
}
