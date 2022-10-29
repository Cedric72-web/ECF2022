<?php

namespace App\Form;

use App\Entity\Franchise;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class NewFranchiseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'form-control my-3'
                ],
                'label' => 'Nom :',
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
                'label' => 'Email :',
            ])
            ->add('password', PasswordType::class, [
                'attr' => [
                    'class' => 'form-control my-3'
                ],
                'label' => 'Mot de passe :'
            ])
            ->add('id_user', EntityType::class, [
                'label' => 'Propriétaire :',
                'class' => User::class,
                'attr' => [
                    'class' => 'form-control my-3'
                ],
                'choice_label' => 'username'
            ])
            ->add('activate', ChoiceType::class, [
                'choices' => [
                    'Activée' => true,
                    'Non activée' => false,
                ],
                'expanded' => true,
                'label' => 'Status :',
                'attr' => [
                    'class' => 'form-check-label'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Franchise::class,
        ]);
    }
}
