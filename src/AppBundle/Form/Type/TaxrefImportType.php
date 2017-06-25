<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaxrefImportType extends AbstractType
{
	/**
     * {@inheritdoc}
     */
	public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        	->add('attachement', FileType::class, [
                'label' => 'Import CSV',
            ])
            ->add('valider', SubmitType::class)
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\TaxrefImport'
        ));
    }

}

?>
