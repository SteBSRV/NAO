<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
	/**
     * {@inheritdoc}
     */
	public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        	->add('address',         TextType::class, [
                'label' => 'Adresse',
            ])
            ->add('postalCode',         IntegerType::class, [
                'label' => 'Code postal',
            ])
            ->add('city',       TextType::class, [
                'label'    => 'Ville',
            ])
            ->add('lat',       NumberType::class, [
                'label'    => 'Longitude',
                'scale'    => 10,
            ])
            ->add('lng',       NumberType::class, [
                'label'    => 'Latitude',
                'scale'    => 10,
            ])
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Address'
        ));
    }

}

?>
