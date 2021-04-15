<?php

namespace App\Form;

use App\Entity\User;
use \Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use \Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email',EmailType::class,[
                'required' => false,
                'label' => 'Email',
                'attr' => ['placeholder' => 'john.doe@exemple.fr']
            ])
            /*->add('roles')*/
            ->add('password',RepeatedType::class,[
                'type' => PasswordType::class,
                'invalid_message' => 'Les champs de mot de passe doivent correspondre.',
                'options' => ['attr' => ['class' => 'password-field', 'placeholder' => 'Ex_2mdp1']],
                'required' => false,
                'first_options' => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Répéter le mot de passe'],
                'help' => 'Votre mot de passe comportera au minimum 8 caractères, au moins 1 chiffre, 1 majuscule et 1 caractère spécial',
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'label' => 'Mot de passe',
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => "Votre mot de passe doit contenir au moins '{{ limit }}' caractères",
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                    new Regex([
                        'pattern' => "/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/i",
                        'message' => 'Doit comporter 8 caractères ou plus, contenir au moins un chiffre, une lettre majuscule, une lettre minuscule et un caractère spécial.'
                    ])
                ],
            ])
            ->add('nom',TextType::class,[

            ])
            ->add('prenom',TextType::class,[

            ])
            ->add('login',TextType::class,[

            ])
            ->add('telephone',TextType::class,[

            ])
            ->add('adresse',TextType::class,[

            ])
            ->add('ville',TextType::class,[

            ])
            ->add('pays',ChoiceType::class,[

            ])
            ->add('dateDeNaissance',DateType::class,[

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
