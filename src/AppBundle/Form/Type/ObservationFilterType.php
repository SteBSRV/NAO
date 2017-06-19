<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ObservationFilterType extends AbstractType
{
	/**
     * {@inheritdoc}
     */
	public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('bird',         EntityType::class, [
                'class' => 'AppBundle:Taxref',
                'choice_label' => 'nomVer',
                'required' => true,
                'label'       => 'Espèce',
            ])
            ->add('dateSince', ChoiceType::class, [
                'choices'  => [
                    'Moins de 3 jours' => 3,
                    'Moins d\'une semaine' => 7,
                    'Moins d\'un mois' => 31,
                    'Toutes les dates' => 0,
                    ],
                'placeholder' => 'Période',
                'label' => 'Date',
                'required' => false,
            ])
            ->add('region',       TextType::class, [
            	'required' => false,
            	'label' => 'Region',
            ])
            ->add('city',       TextType::class, [
                'required' => false,
                'label' => 'Ville',
            ])
            ->add('popularity', ChoiceType::class, [
                'choices'  => [
                    'Les plus populaires' => true,
                    'Les moins populaires' => false,
                    ],
                'label' => 'Popularité',
                'placeholder' => 'Popularité',
                'required' => false,
            ])
            ->add('nbObserved',         IntegerType::class, [
                'label'       => 'Nombre',
                'required' => false,
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
            'data_class' => 'AppBundle\Entity\ObservationFilter'
        ));
    }

}

?>
