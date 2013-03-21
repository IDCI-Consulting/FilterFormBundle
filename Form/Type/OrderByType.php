<?php

namespace IDCI\Bundle\FilterFormBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class OrderByType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('field', 'choice', array(
                'multiple'    => false,
                'expanded'    => false,
                'choices'     => $options['data']['available_fields']
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