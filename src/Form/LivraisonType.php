<?php

namespace App\Form;

use App\Entity\Livraison;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LivraisonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numero', NumberType::class, ['label'=>'Numéro de la rue', 'attr'=>['placeholder'=>'Entrer le numéro de votre rue']])
            ->add('rue', TextType::class, ['label'=>'Rue', 'attr'=>['placeholder'=>'Votre rue']] )
            ->add('cp', NumberType::class, ['label'=>'Code postal', 'attr'=>['placeholder'=>'Votre code postal']])
            ->add('ville', TextType::class, ['label'=>'Ville', 'attr'=>['placeholder'=>'Votre ville']])
            ->add('Valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Livraison::class,
        ]);
    }
}
