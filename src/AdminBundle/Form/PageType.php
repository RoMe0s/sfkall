<?php

namespace AdminBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('slug', TextType::class, [
                'label' => 'slug',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'slug'
                ]
            ])
            ->add('status', ChoiceType::class,[
                'placeholder' => 'status',
                'choices' => [
                    'status.no' => false,
                    'status.yes' => true
                ],
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('template', ChoiceType::class, [
                'required' => true,
                'choices' => [
                    'template.default' => 'template.default'
                ],
                'placeholder' => 'template',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('apply', SubmitType::class)
            ->add('save', SubmitType::class);


    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AdminBundle\Entity\Page'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'page';
    }


}
