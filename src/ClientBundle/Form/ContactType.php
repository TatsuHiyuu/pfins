<?php

namespace ClientBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ContactType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, array('label' => 'Nom *'))
            ->add('prenom', TextType::class, array('label' => 'Prenom *'))
            ->add('file', FileType::class)
            ->add('fonction', TextType::class)
            ->add('telephone', TextType::class, array('label' => 'Numéro de téléphone'))
            ->add('portable', TextType::class, array('label' => 'Numéro de portable'))
            ->add('email', TextType::class, array('label' => 'E-mail *'));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ClientBundle\Entity\Contact'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'clientbundle_contact';
    }


}
