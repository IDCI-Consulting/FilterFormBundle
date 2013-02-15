<?php

namespace IDCI\Bundle\FilterFormBundle\Form\Filter;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @licence: GPL
 *
 */
abstract class RelationFieldEntityAbstractFilter extends EntityAbstractFilter
{
    public function getFilterFormType()
    {
        return 'entity';
    }

    public function getFilterFormOptions()
    {
        return array(
            'label'         => $this->getFilterFormLabel(),
            'class'         => $this->getEntityClassName(),
            'query_builder' => $this->getQueryBuilder(),
            'required'      => false
        );
    }

    public function generateAlias($table_name, $field_name)
    {
        return self::slugify($this->getEntityClassName().$table_name.$field_name);
    }

    static public function slugify($text) 
    { 
        $text = preg_replace('~[^\\pL\d]+~u', '_', $text); 
        $text = trim($text, '_'); 
        $text = strtolower($text); 
        $text = preg_replace('~[^-\w]+~', '', $text); 

        return $text; 
    }

    public function getResultQueryBuilder($data, $qb, $name)
    {
        $ids = array();
        foreach($data as $object) {
            $ids[] = $object->getId();
        }

        if(is_null($this->getOption("mode")) || $this->getOption("mode") == "or") {
            $alias = $this->generateAlias($name, $this->getEntityFieldName());
            $qb->leftJoin(
                sprintf('%s.%s', $name, $this->getEntityFieldName()),
                $alias
            );
            $column = sprintf('%s.id', $alias);
            $qb->andWhere($qb->expr()->in($column, $ids));
        } elseif($this->getOption("mode") == "and") {
            foreach ($ids as $id) {
                $alias = sprintf("%s%d",
                    $this->generateAlias($name, $this->getEntityFieldName()),
                    $id
                );
                $qb->leftJoin(
                    sprintf('%s.%s', $name, $this->getEntityFieldName()),
                    $alias
                );
                $column = sprintf('%s.id', $alias);
                $qb->andWhere($column." = ".$id);
            }
        }

        return $qb;
    }
}
