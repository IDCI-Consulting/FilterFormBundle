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
        $builder
            ->add('min', 'text', array(
                'label' => $options['data']['min_label']
            ))
            ->add('max', 'text', array(
                'label' => $options['data']['max_label']
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