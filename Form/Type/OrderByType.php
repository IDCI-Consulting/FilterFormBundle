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
class OrderByType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('field', 'choice', array(
                'multiple' => false,
                'expanded' => false,
                'choices'  => $options['data']['available_fields'],
                'data'     => key($options['data']['available_fields']),
                'label'    => $options['data']['field_label']
            ))
            ->add('order', 'choice', array(
                'multiple' => false,
                'expanded' => true,
                'choices'  => $options['data']['available_orders'],
                'data'     => $options['data']['default_order']
            ))
        ;
    }

    public function getParent()
    {
        return 'field';
    }

    public function getName()
    {
        return 'orderby';
    }
}