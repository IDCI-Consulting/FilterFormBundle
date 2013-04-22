<?php

namespace IDCI\Bundle\FilterFormBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @licence: GPL
 *
 */
class DateRangeType extends RangeType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('min', 'date', array(
                'format' => 'dd-MM-yy',
                'widget' => 'single_text',
                'required'  => false
            ))
            ->add('max', 'date', array(
                'format' => 'dd-MM-yy',
                'widget' => 'single_text',
                'required'  => false
            ))
        ;
    }

    public function getName()
    {
        return 'date_range';
    }
}