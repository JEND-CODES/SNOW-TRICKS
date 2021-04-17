<?php

namespace App\Form;

use App\Entity\Figure;
use App\Entity\Classification;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class FigureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('classification', EntityType::class, [
                'class' => Classification::class,
                'choice_label' => 'title'
            ])
            ->add('screens', CollectionType::class, [
                'entry_type' => ScreenType::class,
                'entry_options' => ['label' => false],
                // Tests réussis du 10 & 11 avril
                // Options qui permettent d'ajouter ou de supprimer une nouvelle entrée (vidéo ou image) dynamiquement
                'allow_add' => true,
                'allow_delete' => true,
                // Ce paramètre permet de récupérer automatiquement l'ID du Post, de lier cet ID comme clé étrangère dans la table Screen
                'by_reference' => false,
            ])
            ->add('content', TextareaType::class, array(
                'required' => false,
                'attr' => array('class' => 'tinymce')
            ))
            ->add('image')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Figure::class,
        ]);
    }
    
}
