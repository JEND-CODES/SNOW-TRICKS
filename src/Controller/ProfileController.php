<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Security\Core\Security;

use App\Form\ProfileType;
use App\Service\RemoveFile;
use App\Service\FileUploader;

class ProfileController extends AbstractController
{
    private $security;
    private $uploader;
    private $remover;

    public function __construct(Security $security, FileUploader $uploader, RemoveFile $remover)
    {
        $this->security = $security;
        $this->uploader = $uploader;
        $this->remover = $remover;
    }

    public function miniMessage(): Response
    {

        // Tuto suivi pour ajouter sur toutes les pages les mêmes informations : https://symfony.com/doc/current/templates.html#reusing-template-contents

        $miniMessage = "Même message sur toutes les pages !";

        return $this->render('profile/profile.html.twig', [
            'miniMessage' => $miniMessage,
        ]);

        // Mais comment rendre un formulaire fonctionnel sur toutes les pages ?
        // https://symfony.com/doc/current/forms.html#rendering-forms

    }

    public function colors(): Response
    {

        $colors = ['rouge', 'bleu', 'vert'];
        

        return $this->render('profile/colors.html.twig', [
            'colors' => $colors,
        ]);

    }

    /* 
    
    public function profile(Request $request, EntityManagerInterface $manager)
    {
        $current_member2 = $this->security->getUser();

        $imgForm2 = '';

        if(!is_null($current_member2)) {

            $profile_img2 = $this->security->getUser()->getAvatar();

            $avatarForm2 = $this->createForm(ProfileType::class, $current_member2);

            $avatarForm2->handleRequest($request);

            $avatarForm2->createView();

            $imgForm2 = $avatarForm2->createView();

            if($avatarForm2->isSubmitted() && $avatarForm2->isValid()) 
            {
                $this->remover->deleteFile($profile_img2);
                
                $avatarFileMore = $avatarForm2->get('avatar')->getData();

                if ($avatarFileMore) {

                    $avatarFileMoreName = $this->uploader->upload($avatarFileMore);

                    $current_member2->setAvatar($avatarFileMoreName);

                }

                
                $manager->persist($current_member2);

                $manager->flush();

                $this->addFlash(
                    'notice',
                    'Compte mis à jour'
                );
                
                return $this->redirectToRoute('blog');

            }

        }

        return $this->render('profile/formTest.html.twig', [
            'current_member2' => $current_member2,
            'imgForm2' => $imgForm2
        ]);
    } 
    
    */
    


    
}
