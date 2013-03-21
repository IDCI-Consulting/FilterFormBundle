<?php

namespace IDCI\Bundle\FilterFormBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RangeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('min', 'text')
            ->add('max', 'text')
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