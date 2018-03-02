<?php

namespace ReclamationBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class reclamationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre',\Symfony\Component\Form\Extension\Core\Type\TextType::class ,array('attr'=>array('placeholder'
            =>'Tite','class'=>'wp-form-control wpcf7-text')))
            ->add('text',\Symfony\Component\Form\Extension\Core\Type\TextType::class ,array('attr'=>array('placeholder'
            =>'Text','class'=>'wp-form-control wpcf7-textarea')))
            ->add('email',\Symfony\Component\Form\Extension\Core\Type\TextType::class ,array('attr'=>array('placeholder'
            =>'email','class'=>'wp-form-control wpcf7-text')))
            ->add('file',\Symfony\Component\Form\Extension\Core\Type\FileType::class,array('attr'=>array('placeholder'
            =>'email','class'=>'wp-form-control wpcf7-text')))


            ->add('service', EntityType::class, array(
                'class'=>'UserBundle:service',
                'choice_label' => 'nom',
                'multiple' => false,
            ))
            ->add('save',\Symfony\Component\Form\Extension\Core\Type\SubmitType::class ,array('attr'=>array('placeholder'
            =>'save','class'=>'wpcf7-submit button--itzel'
            )));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UserBundle\Entity\reclamation'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'userbundle_reclamation';
    }


}
