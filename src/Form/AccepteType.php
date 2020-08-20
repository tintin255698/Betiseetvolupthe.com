<?php

namespace App\Form;

use App\Entity\Adresse;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccepteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, ['label'=>'Votre nom'])
            ->add('prenom', TextType::class, ['label'=>'Votre prénom '])
            ->add('societe', TextType::class, ['label'=>'Le nom de votre société (facultatif) ', 'required' => false] )
            ->add('adresse', TextType::class, ['label'=>'Votre adresse'])
            ->add('adresse2', TextType::class, ['label'=>'Complément de votre adresse (facultatif)', 'required' => false] )
            ->add('cp', NumberType::class, ['label'=>'Code postal'])
            ->add('ville', TextType::class, ['label'=>'Ville'])
            ->add('Valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Adresse::class,
        ]);
    }
}
