<?php

namespace EvenementBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RassemblementType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom', TextType::class, array('label' => 'Nom *'))
                ->add('date', DateType::class, array(
            'label' => 'Date *',
            'widget' => 'single_text',
            'html5' => false,
            'attr' => [
                'class' => 'dateRassemblement',
                'data-lang' => "fr",
                'data-format' => "Y-m-d",
                'data-min-year' => "2000",
                'data-max-year' => "2100",
                'data-large-mode' => "true"
            ],
        ))
                ->add('lieu', TextType::class, array('label' => 'Lieu *'))
                ->add('nbPDV', NumberType::class, array('label' => 'Nombre de points de vente invités *'))
                ->add('placesParPDV', NumberType::class, array('label' => 'Nombre de personne par point de vente *'))
                ->add('nbBC', NumberType::class, array('label' => 'Nombre d\'invités au total *'))
                ->add('commentaires', TextareaType::class, array('label' => 'Commentaires *'))
                ->add('Enregistrer', SubmitType::class,
                array(
                    'attr' => array('class' => 'form-submit turquoise medium')
                )
            );
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EvenementBundle\Entity\Rassemblement'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'evenementbundle_rassemblement';
    }


}
