<?php

namespace App\Form;

use App\Entity\Franchise;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class EditFranchiseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class, [
                'attr' => [
                    'class' => 'form-control my-3'
                ],
                'label' => 'Nom d\'utilisateur :'
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
            ->add('id_user', EntityType::class, [
                'label' => 'Propriétaire :',
                'class' => User::class,
                'attr' => [
                    'class' => 'form-control my-3'
                ],
                'choice_label' => 'username'
            ])
            ->add('is_activate', ChoiceType::class, [
                'choices' => [
                    'Activée' => true,
                    'Non activée' => false,
                ],
                'choice_attr' => [
                    'class' => 'form-check-label mx-3'
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
