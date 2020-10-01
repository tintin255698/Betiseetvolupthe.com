<?php

namespace App\Form;

use App\Entity\ComposantMenu;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModifyComposantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
           $builder
               ->add('produit', TextType::class,  [
                   'label' => "Nom du produit",
                   'attr' => ['placeholder' => "Modifier le nom"]
               ])
               ->add('type', TextType::class,  [
                   'label' => "Type du produit : entree, plat, dessert",
                   'attr' => ['placeholder' => "Modifier entree, plat, dessert"]
               ])
               ->add('valider', SubmitType::class)
           ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ComposantMenu::class,
        ]);
    }
}
