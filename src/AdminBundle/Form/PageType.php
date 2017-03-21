<?php

namespace AdminBundle\Form;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use A2lix\TranslationFormBundle\Form\Type\TranslationsType;

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
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'slug',
                ]
            ])
            ->add('status', ChoiceType::class,[
                'placeholder' => 'status',
                'required' => false,
                'choices' => [
                    'status.no' => false,
                    'status.yes' => true
                ],
                'attr' => [
                    'class' => 'chosen-select form-control'
                ]
            ])
            ->add('template', ChoiceType::class, [
                'placeholder' => 'template',
                'choices' => $options['templates'],
                'required' => false,
                'attr' => [
                    'class' => 'chosen-select form-control'
                ]
            ])
            ->add('parent_id', ChoiceType::class, [
                'placeholder' => 'parent',
                'choices' => $options['parents'],
                'required' => false,
                'attr' => [
                    'class' => 'chosen-select form-control'
                ]
            ])
            ->add('image', FileType::class, [
                'label' => 'image',
                'required' => false,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('apply', SubmitType::class)
            ->add('save', SubmitType::class)
            ->add('translations', TranslationsType::class,[
                'fields' => [
                    'title' => [
                        'label' => 'title',
                        'attr' => [
                            'placeholder' => 'title',
                            'class' => 'form-control'
                        ]
                    ],
                    'description' => [
                        'label' => 'description',
                        'attr' => [
                            'placeholder' => 'description',
                            'class' => 'form-control'
                        ]
                    ],
                    'meta_title' => [
                        'label' => 'meta_title',
                        'attr' => [
                            'placeholder' => 'meta_title',
                            'class' => 'form-control'
                        ]
                    ],
                    'meta_description' => [
                        'label' => 'meta_description',
                        'attr' => [
                            'placeholder' => 'meta_description',
                            'class' => 'form-control'
                        ]
                    ],
                    'meta_keywords' => [
                        'label' => 'meta_keywords',
                        'attr' => [
                            'placeholder' => 'meta_keywords',
                            'class' => 'form-control'
                        ]
                    ],
                    'content' => [
                        'field_type' => HiddenType::class
                    ]
                ]
            ]);

    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AdminBundle\Entity\Page',
            'cascade_validation' => true,
            'templates' => array(),
            'parents' => array()
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
