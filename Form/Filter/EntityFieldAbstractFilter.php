<?php

namespace IDCI\Bundle\FilterFormBundle\Form\Filter;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @licence: GPL
 *
 */
abstract class EntityFieldAbstractFilter extends EntityAbstractFilter
{
    abstract public function getEntityFieldName();
}
