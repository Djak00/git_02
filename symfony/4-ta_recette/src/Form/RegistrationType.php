<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fullName', TextType::class, [
                'attr' => ['class' => 'form-control', 'minlenght' => '2', 'maxlenght' => '50'],
                'label' => 'Nom / Prénom',
                'label_attr' => ['class' => 'form-label mt-4'],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 2, 'max' => 50])
                ]
            ])
            ->add('pseudo', TextType::class, [
                'attr' => ['class' => 'form-control', 'minlenght' => '2', 'maxlenght' => '50'],
                'required' => false,
                'label' => 'Pseudo (Facultatif)',
                'label_attr' => ['class' => 'form-label mt-4'],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 50])
                ]
            ])
            ->add('email', EmailType::class, [
                'attr' =>  ['class' => 'form-control', 'minlenght' => '2', 'maxlenght' => '180'],
                'label' => 'Adresse email',
                'label_attr' => ['class' => 'form-label mt-4'],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Email(),
                    new Assert\Length(['min' => 2, 'max' => 180])
                ]
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'attr' => ['class' => 'form-control'],
                    'label' => 'Mot de passe',
                    'label_attr' => ['class' => 'form-label mt-4'],
                ],
                'second_options' => [
                    'attr' => ['class' => 'form-control'],
                    'label' => 'Confimation du mot de passe ',
                    'label_attr' => ['class' => 'form-label mt-4'],
                ],
                'invalid_message' => 'les mots de passe ne correspondent pas.'
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mt-4'
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
