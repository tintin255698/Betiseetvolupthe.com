<?php

namespace App\Form;

use App\Entity\Repas;
use App\Repository\RepasRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MenuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', EntityType::class, [
                'class' => Repas::class,
                'query_builder' => function (RepasRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->select('u, u.produit, u.id, u.type' )
                        ->andwhere('u.type= :entre')
                        ->setParameter('entre', 'entre');
                },
                'choice_label' => function ($category) {
                    return $category->getType();
                }
            ])
        ->add('type', EntityType::class, [
        'class' => Repas::class,
        'query_builder' => function (RepasRepository $er) {
            return $er->createQueryBuilder('u')
                ->andwhere('u.type= :plat')
                ->setParameter('plat', 'plat');
        },
            'choice_label' => function ($category) {
                return $category->getType();
            }
        ])
        ->add('type', EntityType::class, [
        'class' => Repas::class,
        'query_builder' => function (RepasRepository $er) {
            return $er->createQueryBuilder('u')
                ->andwhere('u.type= :plat')
                ->setParameter('plat', 'dessert');
        },
        'choice_label' => 'type',
    ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
