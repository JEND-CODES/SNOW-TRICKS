<?php

namespace App\Form;

use App\Entity\Member;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;


class ResetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ->add('email')    
            ->add('username')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Member::class,
            // On souhaite envoyer l'email de réinitialisation du mot de passe oublié par un membre
            // L'utilisateur doit seulement entrer son pseudo pour vérification
            // On ne souhaite pas enregistrer un nouveau pseudo mais seulement vérifier son existence en base de données
            // Donc -> Désactivation de la validation des données soumises
            // https://symfony.com/doc/current/form/disabling_validation.html
            'validation_groups' => false
        ]);
    }
}
