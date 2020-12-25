<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('old_password', PasswordType::class, [
                'label' => 'Votre mot de passe actuel',
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Votre mot de passe actuel'
                ]
            ])
            ->add('new_password', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'invalid_message' => 'Les mots de passes saisis doivent être identiques',
                'required' => true,
                'label' => 'Votre nouveau mot de passe',
                'first_options' => [
                    'label' => 'Votre nouveau mot de passe',
                    'attr' => [
                        'placeholder' => 'Entrez votre nouveau mot de passe'
                    ]
                ],
                'second_options' => [
                    'label' => 'Confirmez votre nouveau mot de passe',
                    'attr' => [
                        'placeholder' => 'Confirmez votre nouveau mot de passe'
                    ]
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Sauvegarder'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
