<?php

namespace IDCI\Bundle\FilterFormBundle\Form\Filter;

use IDCI\Bundle\FilterFormBundle\Form\Filter\RelationFieldEntityAbstractFilter;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @license: GPL
 *
 */
abstract class MultipleSelectRelationFieldEntityAbstractFilter extends RelationFieldEntityAbstractFilter
{
    public function getFilterFormOptions() {
        $filterFormOptions = parent::getFilterFormOptions();

        return array_merge($filterFormOptions, array(
            'multiple' => true,
            'expanded' => false
        ));
    }
}
