<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MdpType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ancienMDP', PasswordType::class, ['label'=>'Ancien mot de passe', 'attr'=>['placeholder'=>'Entrer votre ancien mot de passe']])
            ->add('nouveauMDP', PasswordType::class, ['label'=>'Nouveau mot de passe', 'attr'=>['placeholder'=>'Saisir votre nouveau mot de passe']])
            ->add('confirmerMDP', PasswordType::class, ['label'=>'Confirmer mot de passe', 'attr'=>['placeholder'=>'Confimer votre nouveau mot de passe']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
