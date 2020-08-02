<?php

namespace App\Form;

use App\Entity\Reservation;
use libphonenumber\PhoneNumberFormat;
use Misd\PhoneNumberBundle\Form\Type\PhoneNumberType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [ 'attr'=>['placeholder'=>'Votre nom']])
            ->add('email', EmailType::class, [ 'attr'=>['placeholder'=>'Votre email ']])
            ->add('telephone', TelType::class, [ 'attr'=>['placeholder'=>'Votre nom']])
            ->add('date', DateType::class, array(
                'widget' => 'single_text',))
            ->add('heure', TimeType::class, array(
                'widget' => 'single_text',))
            ->add('personne', IntegerType::class, [ 'attr'=>['placeholder'=>'Nombre de personne']] )
            ->add('message', TextareaType::class, [
                'required'=>false,
                'attr'=>['placeholder'=>'Message']]  )

        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
