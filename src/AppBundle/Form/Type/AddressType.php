<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
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
                'attr' => ['onchange' => 'codeAddress()'],
            ])
            ->add('postalCode',         IntegerType::class, [
                'label' => 'Code postal',
                'attr' => ['onchange' => 'codeAddress()'],
            ])
            ->add('city',       TextType::class, [
                'label'    => 'Ville',
                'attr' => ['onchange' => 'codeAddress()'],
            ])
            ->add('ltd',       HiddenType::class, [
                'label'    => 'Latitude',
            ])
            ->add('lgt',       HiddenType::class, [
                'label'    => 'Longitude',
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
