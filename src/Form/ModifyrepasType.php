<?php

namespace App\Form;

use App\Entity\Repas;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModifyrepasType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('produit', TextType::class,
                [
                    'label' => "Nom de la boisson",
                    'attr' => ['placeholder' => "Modifier le nom"]
                ])
            ->add('prix', MoneyType::class,
                [
                    'label' => "Prix de la boisson",
                    'attr' => ['placeholder' => "Modifier le prix"]
                ])
            ->add('type', TextType::class,
                [
                    'label' => "Type de produit : eau, vin, biere, the, limonade, jus",
                    'attr' => ['placeholder' => "Modifier le type"]
                ])
            ->add('description', TextType::class,
                [
                    'label' => "Description de la boisson (facultatif)",
                    'required'=>false,
                    'attr' => ['placeholder' => "Ajouter/modifierDescription"]
                ])
            ->add('valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Repas::class,
        ]);
    }
}
