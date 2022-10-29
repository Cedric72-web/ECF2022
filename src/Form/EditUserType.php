<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class EditUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname',TextType::class, [
                'attr' => [
                    'class' => 'form-control my-3'
                ],
                'label' => 'Nom :'
            ])
            ->add('firstname',TextType::class, [
                'attr' => [
                    'class' => 'form-control my-3'
                ],
                'label' => 'Prénom :'
            ])
            ->add('email', EmailType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir une adresse email'
                    ])
                ],
                'required' => true,
                'attr' => [
                    'class' => 'form-control my-3'
                ],
                'label' => 'Email :'
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Structure' => 'ROLE_PARTNER',
                    'Franchise' => 'ROLE_FRANCHISE',
                    'Administrateur' => 'ROLE_ADMIN',
                ],
                'choice_attr' => [
                    'class' => 'form-check-label mx-3'
                ],
                'expanded' => true,
                'multiple' => true,
                'label' => 'Rôles :',
                'attr' => [
                    'class' => 'form-check-label'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
