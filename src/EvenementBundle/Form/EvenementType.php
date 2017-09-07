<?php

namespace EvenementBundle\Form;

use ClientBundle\Form\ClientType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class EvenementType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('statut', EntityType::class, array(
                'class' => 'EvenementBundle\Entity\Statut',
                'choice_value' => 'id',
                'choice_label' => 'nom',
            ))
            ->add('client', EntityType::class, array(
                'class' => 'ClientBundle\Entity\Client',
                'choice_value' => 'id',
                'choice_label' => 'marque',
            ))
            ->add('nom', textType::class)
            ->add('dateDebut', DateType::class, array(
                'widget' => 'single_text',
                'html5' => false,
                'attr' => [
                            'class' => 'dateDebut',
                            'data-lang' => "fr",
                            'data-format' => "Y-m-d",
                            'data-min-year' => "2000",
                            'data-max-year' => "2100",
                            'data-large-mode' => "true"
                          ],
            ))
            ->add('dateFin', DateType::class, array(
                'widget' => 'single_text',
                'html5' => false,
                'attr' => [
                            'class' => 'dateFin',
                            'data-lang' => "fr",
                            'data-format' => "Y-m-d",
                            'data-min-year' => "2000",
                            'data-max-year' => "2100",
                            'data-large-mode' => "true"
                          ],
            ))
            ->add('description', TextareaType::class, array('label' => 'Description'))
            ->add('documents', CollectionType::class, array(
                'label' => false,
                'entry_type'    => DocumentType::class,
                'allow_add'     => true,
                'allow_delete'  => true
            ))
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
            'data_class' => 'EvenementBundle\Entity\Evenement'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'evenementbundle_evenement';
    }


}
