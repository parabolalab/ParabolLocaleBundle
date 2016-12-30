<?php

namespace Parabol\LocaleBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CountryEntityType extends AbstractType {
	public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
           'multiple' => true,
           'expanded' => true,
        ));
    }

    public function getParent()
    {
        return EntityType::class;
    }
}