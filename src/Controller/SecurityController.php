<?php

// A faire : configurer des pages d'erreurs pour la version online/production du site (https://symfony.com/doc/current/controller/error_pages.html)

// Faire une MACRO de messages d'alertes avec Twig ?? (https://openclassrooms.com/fr/courses/5489656-construisez-un-site-web-a-l-aide-du-framework-symfony-4/5517021-dynamisez-vos-vues-a-l-aide-de-twig)

// Voir en détail les Contraints de validation (https://symfony.com/doc/current/reference/constraints.html) et (https://openclassrooms.com/fr/courses/5489656-construisez-un-site-web-a-l-aide-du-framework-symfony-4/5517026-interagissez-avec-vos-utilisateurs)

// Pour authentification et accès d'un administrateur du site voir : https://openclassrooms.com/fr/courses/5489656-construisez-un-site-web-a-l-aide-du-framework-symfony-4/5654131-securisez-lacces-de-votre-site-web + voir annotation @IsGranted() 


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Member;
use App\Form\MemberType;

use Symfony\Component\HttpFoundation\Request;

// Ne marche plus dans la version Symfony 5 ?
// Voir : problème résolu avec ObjectManager : https://openclassrooms.com/forum/sujet/symfony5-objectmanager
// use Doctrine\Common\Persistence\ObjectManager;
// Remplacé par : 
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;




class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="security_registration")
     */
    public function registration(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
        $member = new Member();
        
        $formSecurity = $this->createForm(MemberType::class, $member);
        
        $formSecurity->handleRequest($request);
        
        if($formSecurity->isSubmitted() && $formSecurity->isValid())
        {
            $hash = $encoder->encodePassword($member, $member->getPassword());
            
            $member->setPassword($hash);
            
            $manager->persist($member);
            $manager->flush();
            
            return $this->redirectToRoute('security_connexion');
        }
    
        return $this->render('security/registration.html.twig', [
            'formSecurity' => $formSecurity->createView()
        ]);
    }
    
    
    /**
     * @Route("/connexion", name="security_connexion")
     */
    public function connexion()
    {
        return $this->render('security/connexion.html.twig');
    }
    
    /**
     * @Route("/disconnect", name="security_disconnect")
     */
    public function disconnect() {}
    
}
