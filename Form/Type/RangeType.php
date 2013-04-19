<?php

namespace IDCI\Bundle\FilterFormBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @licence: GPL
 *
 */
class RangeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if(!isset($options['data'])) {
            $options['data']['min_label'] = "From";
            $options['data']['max_label'] = "to";
        }
        if(!isset($options['data']['min_label'])) {
            $options['data']['min_label'] = "From";
        }
        if(!isset($options['data']['max_label'])) {
            $options['data']['max_label'] = "to";
        }
        $builder
            ->add('min', 'text', array(
                'label'     => $options['data']['min_label'],
                'required'  => false
            ))
            ->add('max', 'text', array(
                'label'     => $options['data']['max_label'],
                'required'  => false
            ))
        ;
    }

    public function getParent()
    {
        return 'field';
    }

    public function getName()
    {
        return 'range';
    }
}