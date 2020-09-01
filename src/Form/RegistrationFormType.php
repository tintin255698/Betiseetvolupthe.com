<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('prenom', TextType::class, ['label'=>'Prénom', 'attr'=>['placeholder'=>'Entrer votre prenom']])
            ->add('nom', TextType::class, ['label'=>'Nom', 'attr'=>['placeholder'=>'Entrer votre nom']] )
            ->add('telephone', TelType::class, ['label'=>'Téléphone', 'attr'=>['placeholder'=>'Entrer votre téléphone ']])

            ->add('email', EmailType::class, ['label'=>'Email', 'attr'=>['placeholder'=>'Entrer votre email']])

            ->add('plainPassword', RepeatedType::class, array(
                'first_name' => 'pass',
                'second_name' => 'confirm',
                'type' => PasswordType::class,
                'label'=>'Mot de passe',
                'attr'=>['placeholder'=>'Entrer votre mot de passe'],
                'mapped' => false,
                'constraints' => array (
                    new NotBlank([
                        'message' => "Merci d'entrer un mot de passe",
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir au minimum 6 caracteres',
                        'max' => 4096,

                    ])),
                'first_options' => array('label' => 'Mot de passe', 'attr'=>['placeholder'=>'Entrer votre mot de passe']),
                'second_options'=> array('label' => 'Confirmation du mot de passe', 'attr'=>['placeholder'=>'Entrer la confirmation de votre mot de passe']),
            ))
            ->add('agreeTerms', CheckboxType::class, [
                'label'=>'Accepter les conditions : ',
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => "Vous devez être d'accord avec nos conditions.",
                    ]),
                ],
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
