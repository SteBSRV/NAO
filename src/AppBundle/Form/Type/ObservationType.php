<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Form\Type\AddressType;

class ObservationType extends AbstractType
{
	/**
     * {@inheritdoc}
     */
	public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        	->add('imageFile',         VichImageType::class, [
                'required' => false,
                'label' => 'Photo',
                'allow_delete'  => true,
                'download_link' => true,
            ])
            ->add('date',         DateTimeType::class, [
                'label' => 'Date de l\'observation',
                'data' => new \DateTime("now"),
            ])
            ->add('address',       AddressType::class, [
            	'required' => false,
            	'label' => 'Localisation',
            ])
            ->add('bird',         EntityType::class, [
            	'class' => 'AppBundle:Taxref',
            	'choice_label' => 'nomVer',
            	'required' => false,
                'label'       => 'Espèce',
            ])
            ->add('nbObserved',         IntegerType::class, [
                'label'       => 'Nombre',
            ])
            ->add('description',           TextareaType::class, [
                'label'        => 'Description'
            ])
            ->add('valider',              SubmitType::class)
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Observation'
        ));
    }

}

?>