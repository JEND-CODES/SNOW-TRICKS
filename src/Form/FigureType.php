<?php

namespace App\Form;

use App\Entity\Figure;
use App\Entity\Classification;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

// Cf. https://symfony.com/doc/current/reference/forms/types/choice.html
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

// Lier un FormType avec un autre pour enregistrer les champs pour deux entités avec un seul formulaire, voir l'utilisation de "CollectionType" :
// https://symfony.com/doc/current/form/form_collections.html
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
            // Liaison d'un autre FormType 
            /*
            ->add('mentions', CollectionType::class, [
                'entry_type' => MentionType::class,
                'entry_options' => ['label' => false],
            ])
            */
            // Liaison du ScreenType
            ->add('screens', CollectionType::class, [
                'entry_type' => ScreenType::class,
                'entry_options' => ['label' => false],
            ])
            // Intégration de TinyMCE :
            // Mettre le "required" à "false" pour enregistrer le champs TinyMCE sinon ça marche pas..? Voir : https://stackoverflow.com/questions/10303431/cant-submit-a-form-with-symfony2-and-tinymce
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
