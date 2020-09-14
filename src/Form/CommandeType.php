<?php

namespace App\Form;

use App\Entity\Commande;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, ['label'=>'Nom', 'attr'=>['placeholder'=>'Jone']])
            ->add('prenom', TextType::class, ['label'=>'Prénom', 'attr'=>['placeholder'=>'Jone']])
            ->add('societe', TextType::class, ['label'=>'Société', 'attr'=>['placeholder'=>'Bêtises et Volupthé']])
            ->add('numero', NumberType::class, ['label'=>'Numéro de rue', 'attr'=>['placeholder'=>'79']])
            ->add('adresse', TextType::class, ['label'=>'Adresse', 'attr'=>['placeholder'=>'Rue des Granges']])
            ->add('code', NumberType::class, ['label'=>'Code postal', 'attr'=>['placeholder'=>'25000']])
            ->add('ville', TextType::class, ['label'=>'Ville', 'attr'=>['placeholder'=>'Besançon']])
            ->add('livraison', DateType::class, array(
                'widget' => 'single_text'))
            ->add('valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
