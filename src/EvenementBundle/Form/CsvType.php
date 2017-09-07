<?php

namespace EvenementBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;


class CsvType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', FileType::class, array(
                'constraints' => array(
                    new NotBlank(),
                    new Assert\File(array(
                        'mimeTypes' => array(
//                            'text/csv'
                        )
                    ))
                ),
            ))
            ->add('Enregistrer', SubmitType::class,
                array(
                    'attr' => array('class' => 'form-submit turquoise medium')
                )
            );

    }

}
