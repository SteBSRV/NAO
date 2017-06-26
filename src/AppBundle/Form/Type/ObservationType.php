<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
use AppBundle\Repository\TaxrefRepository;

class ObservationType extends AbstractType
{
	/**
     * {@inheritdoc}
     */
	public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $role = $options['role'];
        if (in_array('ROLE_ADMIN', $role) || in_array('ROLE_SUPER_ADMIN', $role)) {
            $builder
                ->add('imageFile',         VichImageType::class, [
                    'required' => false,
                    'label' => 'Photo',
                    'allow_delete'  => true,
                    'download_link' => true,
                ])
                ->add('observeAt',         DateTimeType::class, [
                    'label' => 'Date de l\'observation',
                    'data' => new \DateTime("now"),
                    'format' => 'dd/MM/yyyy H:m',
                    'widget' => 'single_text',
                    'html5' => 'false'
                ])
                ->add('address',       AddressType::class, [
                    'required' => false,
                    'label' => 'Localisation',
                ])
                ->add('bird',         EntityType::class, [
                    'class' => 'AppBundle:Taxref',
                    'query_builder' => function(TaxrefRepository $trr) {
                        return $trr->getAllNomVer();
                    },
                    'required' => false,
                    'label'       => 'Espèce',
                ])
                ->add('nbObserved',         IntegerType::class, [
                    'label'       => 'Nombre',
                ])
                ->add('state',        ChoiceType::class, [
                    'label'       => 'Statut',
                    'choices'  => [
                        'Valider' => true,
                        'Ne pas valider' => false,
                    ]
                ])
                ->add('description',           TextareaType::class, [
                    'label'        => 'Description'
                ])
                ->add('valider',              SubmitType::class)
            ;
        }
        else{
            $builder
                ->add('imageFile',         VichImageType::class, [
                    'required' => false,
                    'label' => 'Photo',
                    'allow_delete'  => true,
                    'download_link' => true,
                ])
                ->add('observeAt',         DateTimeType::class, [
                    'label' => 'Date de l\'observation',
                    'data' => new \DateTime("now"),
                    'format' => 'dd/MM/yyyy H:m',
                    'widget' => 'single_text',
                    'html5' => 'false'
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

    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Observation',
            'role' => null
        ));
    }

}
