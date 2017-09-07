<?php

namespace ClientBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ClientType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('marque', TextType::class)
            ->add('file', FileType::class)
            ->add('adresse', TextType::class)
            ->add('adresseCP', TextType::class)
            ->add('adresseVille', TextType::class)
            ->add('site', TextType::class)
            ->add('commentaires', TextareaType::class)
            ->add('contacts', CollectionType::class, array(
                'label' => false,
                'entry_type'    => ContactType::class,
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
            'data_class' => 'ClientBundle\Entity\Client'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'clientbundle_client';
    }


}
