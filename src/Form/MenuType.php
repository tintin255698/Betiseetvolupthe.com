<?php

namespace App\Form;

use App\Entity\Menu;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MenuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('produit', TextType::class,
                [
                    'label' => "Nom du menu",
                    'attr' => ['placeholder' => "Modifier le nom"]
                ])
            ->add('prix', MoneyType::class,
                [
                    'label' => "Prix du produit",
                    'attr' => ['placeholder' => "Modifier le prix"]
                ])
            ->add('description', TextType::class, [
                'label' => "Description du menu (facultatif)",
                'required'=>false,
                'attr' => ['placeholder' => "Ajouter/modifier la description"]
            ])
            ->add('Valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Menu::class,
        ]);
    }
}
