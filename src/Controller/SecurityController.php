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
use App\Repository\MemberRepository;
use App\Form\NewpassType;
use App\Form\ResetType;
use App\Form\ForgotType;

use Symfony\Component\HttpFoundation\Request;

// Ne marche plus dans la version Symfony 5 ?
// Voir : problème résolu avec ObjectManager : https://openclassrooms.com/forum/sujet/symfony5-objectmanager
// use Doctrine\Common\Persistence\ObjectManager;
// Remplacé par : 
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

// 5 février -> Tests du mailer service de Symfony
// use Symfony\Component\Mailer\MailerInterface;
// use Symfony\Component\Mime\Email;

// 5 février -> Tests du Bundle Swift Mailer

// 11 février -> Dépendance ajoutées pour l'upload de l'image Avatar
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

// IDENTIFICATION DU MEMBRE EN COURS
// CORE\SECURITY -> UTILISÉ POUR AFFICHER LES INFORMATIONS DU MEMBRE CONNECTÉ -> ET POUR OPÉRER DES REDIRECTIONS
// How do I get the entity that represents the current user in Symfony ?
// https://stackoverflow.com/questions/7680917/how-do-i-get-the-entity-that-represents-the-current-user-in-symfony2
use Symfony\Component\Security\Core\Security;


class SecurityController extends AbstractController
{
    
    private $security;

    public function __construct(Security $security)
    {
       $this->security = $security;
    }
    
    // FONCTION D'ENREGISTREMENT DE NOUVEAU MEMBRE
    /**
     * @Route("/inscription", name="security_registration")
     */
    /*
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
    */



    // TEST DE SERVICE MAILER
    /**
     * @Route("/inscription", name="security_registration")
     */
    // 5 février -> Tests du mailer service de Symfony
    /*
    public function registration(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder, MailerInterface $mailer)
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

            
            // 5 FÉVRIER -> TESTS DU MAILER SERVICE DE SYMFONY
            $email = (new Email())
            ->from('noreply@planetcode.com')
            ->to($member->getEmail())
            // ->to($member->getEmail())
            
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!')
            ->html('<p>See Twig integration for better HTML integration!</p>')
            
            // Essayer ça pour l'envoi d'email :
            // ->html(
                // $this->renderView('emails/validation.html.twig', [
                        // 'member' => $member
                    // ]),
                    // 'text/html'
                // )
            

            ;

            $mailer->send($email);
            // var_dump($email);

            // FIN DE TEST MAILER
            

            // return $this->redirectToRoute('security_connexion');
            return $this->redirectToRoute('security_registration');
            
        }
    
        return $this->render('security/registration.html.twig', [
            'formSecurity' => $formSecurity->createView()
        ]);
    }
    */


    // TEST DE SWIFT MAILER
    /**
     * @Route("/inscription", name="security_registration")
     */
    /*
    public function registration(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder, \Swift_Mailer $mailer)
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


            // TEST DE SWIFT MAILER DU 5 FÉVRIER
            $message = (new \Swift_Message('Votre inscription est enregistrée'))
            ->setFrom('noreply@planetcode.fr')
            ->setTo($member->getEmail())
            // Comment faire fonctionner un renderView() ???
            
            ->setBody(
                $this->renderView('emails/registration.html.twig', [
                        'member' => $member
                    ]),
                    'text/html'
                )
            
            ;
            
            $mailer->send($message);
            // var_dump($message);
            // print_r($message);

            // Après avoir entré dans le fichier .env le format attendu : MAILER_URL=gmail://username:password@localhost -> résultat dans la console Symfony : 
            // "Exception occurred while flushing email queue: Connection could not be established with host smtp.gmail.com :stream_socket_client(): SSL operation failed with code 1. OpenSSL Error messages: error:1416F086:SSL routines:tls_process_server_certificate:certificate verify failed"
            // Même problème rencontré en utilisant le service/mailer de Symfony..
            // Peut-on envoyer des messages via localhost ? Il semble qu'il y ait un blocage par défaut généré par les services de messagerie (google et autres)...

            // FIN DE TEST


            
            // return $this->redirectToRoute('security_connexion');
            // return $this->redirectToRoute('security_registration');
        }
    
        return $this->render('security/registration.html.twig', [
            'formSecurity' => $formSecurity->createView(),
            'member' => $member
        ]);
    }
    */
    

    // TEST D'ENREGISTREMENT DU TOKEN
    /**
     * @Route("/inscription", name="security_registration")
     */
    /*
    public function registration(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
        $member = new Member();
        
        $formSecurity = $this->createForm(MemberType::class, $member);
        
        $formSecurity->handleRequest($request);
        
        if($formSecurity->isSubmitted() && $formSecurity->isValid())
        {
            $hash = $encoder->encodePassword($member, $member->getPassword());
            
            $member->setPassword($hash)
                    ->setCreatedAt(new \DateTime)
                    // Generating a Secure Random String
                    // Cf. https://symfony.com/doc/current/components/security/secure_tools.html
                    // ->setToken(md5(random_bytes(10)))
                    // random_bytes — Génère des octets pseudo-aléatoire cryptographiquement sécurisé
                    // Cf. https://www.php.net/manual/fr/function.random-bytes.php
                    ->setToken(hash('sha256', random_bytes(10)))
                    // BOOLEAN / TINYINT(1) - valeur zéro -> false, pas à zéro vaut true
                    // ->setValidation('0')
                    ->setValidation(false)
                    // Integer pour définir le rôle membre
                    ->setStatus('0');
            
            $manager->persist($member);

            $manager->flush();

            // return $this->redirectToRoute('security_connexion');
            // return $this->redirectToRoute('security_registration');
        }
    
        return $this->render('security/registration.html.twig', [
            'formSecurity' => $formSecurity->createView(),
            'member' => $member
        ]);
    }
    */

    // ENREGISTREMENT DU TOKEN + UPLOAD IMAGE + MAILER SERVICE
    /**
     * @Route("/inscription", name="security_registration")
     */
    public function registration(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder, \Swift_Mailer $mailer, SluggerInterface $slugger)
    {
        // IL FAUT ÊTRE DÉCONNECTÉ POUR ACCÉDER À CETTE PAGE !
        // Vérification si un membre est en cours de connexion
        $current_member = $this->security->getUser();

        // Si oui redirection vers Homepage
        if(!is_null($current_member)) {
            return $this->redirectToRoute('blog');
        }

        // ENREGISTREMENT D'UN NOUVEAU MEMBRE
        $member = new Member();
        
        $formSecurity = $this->createForm(MemberType::class, $member);
        
        $formSecurity->handleRequest($request);
        
        if($formSecurity->isSubmitted() && $formSecurity->isValid())
        {
            // ENREGISTREMENT DE L'IMAGE AVATAR
            $avatarFile = $formSecurity->get('avatar')->getData();
            // $avatarFile = $formSecurity->getAvatar();

            if ($avatarFile) {
                $originalFilename = pathinfo($avatarFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$avatarFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    // Ce directory où sont téléchargées les images avatars est défini dans config/services.yaml (voir la section parameters)
                    $avatarFile->move(
                        $this->getParameter('avatars_directory'),
                        $newFilename
                    );

                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload

                    $this->addFlash(
                        'warning',
                        'IMAGE INVALIDE'
                    );

                    return $this->redirectToRoute('security_registration');

                }

                // updates the 'avatarFilename' property to store the file name
                // instead of its contents
                $member->setAvatar($newFilename);

            }
            // FIN D'ENREGISTREMENT DE L'IMAGE AVATAR
            
            $hash = $encoder->encodePassword($member, $member->getPassword());
            
            // GÉNÉRATION D'UN NOUVEAU TOKEN
            $member->setPassword($hash)
                    ->setCreatedAt(new \DateTime)
                    // Generating a Secure Random String
                    // Cf. https://symfony.com/doc/current/components/security/secure_tools.html
                    // ->setToken(md5(random_bytes(10)))
                    // random_bytes — Génère des octets pseudo-aléatoire cryptographiquement sécurisé
                    // Cf. https://www.php.net/manual/fr/function.random-bytes.php
                    ->setToken(hash('sha256', random_bytes(10)))
                    // BOOLEAN / TINYINT(1) - valeur zéro -> false, pas à zéro vaut true
                    // ->setValidation('0')
                    ->setValidation(false)
                    // Integer pour définir le rôle membre
                    ->setStatus('0');

            $manager->persist($member);

            $manager->flush();


            // TEST DE SWIFT MAILER DU 6 FÉVRIER
            $message = (new \Swift_Message('Votre inscription est enregistrée'))
            ->setFrom('noreply@planetcode.fr')
            ->setTo($member->getEmail())
            
            // Comment faire fonctionner un renderView() ???
            
            ->setBody(
                $this->renderView('emails/validation.html.twig', [
                        'member' => $member
                    ]),
                    'text/html'
                )
            
            ;
            
            $mailer->send($message);
            // var_dump($message);
            // print_r($message);

            // Après avoir entré dans le fichier .env le format attendu : MAILER_URL=gmail://username:password@localhost -> résultat dans la console Symfony : 
            // "Exception occurred while flushing email queue: Connection could not be established with host smtp.gmail.com :stream_socket_client(): SSL operation failed with code 1. OpenSSL Error messages: error:1416F086:SSL routines:tls_process_server_certificate:certificate verify failed"
            // Même problème rencontré en utilisant le service/mailer de Symfony..
            // Peut-on envoyer des messages via localhost ? Il semble qu'il y ait un blocage par défaut généré par les services de messagerie (google et autres)...

            // FIN DE TEST DE SWIFT MAILER


            // return $this->redirectToRoute('security_connexion');
            // return $this->redirectToRoute('security_registration');
        }
    
        return $this->render('security/registration.html.twig', [
            'current_member' => $current_member,
            'formSecurity' => $formSecurity->createView(),
            'member' => $member
        ]);
    }
    
    
    /**
     * @Route("/confirm_account/{username}/{token}", name="confirm_account")
     */
    public function confirmAccount(MemberRepository $repoMember, $username, $token, EntityManagerInterface $manager)
    {

        $member = $repoMember->findOneByUsername($username);

        if($token != null && $token === $member->getToken())
        {
            // $member->setValidation('1');
            $member->setValidation(true)
                    ->setStatus('1');
                    // On vide la colonne Token ?
                    // ->setToken('');

            $manager->persist($member);

            $manager->flush();

        } 
        else
        {
            return $this->redirectToRoute('security_registration');
        }

        return $this->redirectToRoute('security_connexion'); 
    }


    // MISE À JOUR DU MOT DE PASSE POUR MEMBRE DÉJÀ CONNECTÉ
    /**
     * @Route("/newpass", name="new_password")
     */
    public function updatePass(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
        // How do I get the entity that represents the current user in Symfony ?
        // https://stackoverflow.com/questions/7680917/how-do-i-get-the-entity-that-represents-the-current-user-in-symfony2

        // IL FAUT ÊTRE CONNECTÉ POUR ACCÉDER À CETTE PAGE !
        // La variable $user renvoie ici au membre connecté
        $current_member = $this->security->getUser();

        // Redirection en cas d'absence de membre connecté..
        if($current_member === null)
        {
            return $this->redirectToRoute('security_connexion');

        } 
  
        $formNewpass = $this->createForm(NewpassType::class, $current_member);
        
        $formNewpass->handleRequest($request);
    
        if($formNewpass->isSubmitted() && $formNewpass->isValid())
        {
            $hash = $encoder->encodePassword($current_member, $current_member->getNewpass());
            
            $current_member->setPassword($hash);

            // $current_member->setNewpass("EMPTY");
            $current_member->setNewpass($hash);
            
            $manager->persist($current_member);

            $manager->flush();
            
            return $this->redirectToRoute('blog');
        }
    
        return $this->render('security/newpass.html.twig', [
            'formNewpass' => $formNewpass->createView(),
            'current_member' => $current_member
        ]);
    }
    

    // !!!!!!!! Attention, il faut veiller à mettre une contrainte UNIQUE sur les pseudos des membres !!!!!!!!

    // FORMULAIRE DE DEMANDE D'UN NOUVEAU MOT DE PASSE
    // Il s'agit ici d'identifier un Membre déjà enregistré (à partir du formulaire) en BDD en fonction de son Pseudo (username), de lui générer un nouveau Token et un Email à partir duquel il va pouvoir ensuite accéder à une page dédiée à la réinitialisation de son mot de passe
    /**
     * @Route("/resetpass", name="reset_password")
     */
    public function resetPass(Request $request, EntityManagerInterface $manager, MemberRepository $repoMember, \Swift_Mailer $mailer)
    {
        // IL FAUT ÊTRE DÉCONNECTÉ POUR ACCÉDER À CETTE PAGE !
        // Vérification si un membre est en cours de connexion
        $current_member = $this->security->getUser();

        // Si oui redirection vers Homepage
        if(!is_null($current_member)) {
            return $this->redirectToRoute('blog');
        }

        // Cela définit au départ le MEMBER à NULL pour ensuite en spécifier la valeur dans le formulaire qui va permettre de filtrer les datas en BDD (-> findOneBy(...)) en fonction du nom d'utilisateur entré par l'internaute
        $member = new Member();

        // Mettre plutôt : " createForm(ResetType::class, $member) " ?? 
        $resetSecurity = $this->createForm(ResetType::class);

        $resetSecurity->handleRequest($request);

        if($resetSecurity->isSubmitted() && $resetSecurity->isValid()) 
        {
            $username = $resetSecurity->getData('username');

            // Attention !! Veiller ici à appeler le getter "$username->getUsername()" de la classe MEMBER (sinon indiquer uniquement $username, ça ne marchera pas !!)
            $member = $repoMember->findOneBy(array('username' => $username->getUsername()));

            if($member !== null)
            {
                // On génère un nouveau Token
                $member->setToken(hash('sha256', random_bytes(10)));

                $manager->persist($member);

                $manager->flush();

                // Message SWIFT MAILER
                $message = (new \Swift_Message('Demande de réinitialisation de votre mot passe Snow Tricks'))
                ->setFrom('noreply@planetcode.fr')
                ->setTo($member->getEmail())
                
                // Comment faire fonctionner un renderView() ???
                
                ->setBody(
                    $this->renderView('emails/diepass.html.twig', [
                            'member' => $member
                        ]),
                        'text/html'
                    )
                
                ;
                
                $mailer->send($message);

            }
           
        }

        return $this->render('security/reset.html.twig', [
            'current_member' => $current_member,
            'resetSecurity' => $resetSecurity->createView(),
            'member' => $member
        ]);
    }

    // MISE À JOUR DU MOT DE PASSE (OUBLIÉ) POUR MEMBRE HORS CONNEXION
    /**
     * @Route("/confirm_reset/{username}/{token}", name="confirm_reset")
     */
    public function confirmReset(Request $request, MemberRepository $repoMember, UserPasswordEncoderInterface $encoder, EntityManagerInterface $manager, $username, $token)
    {
        // IL FAUT ÊTRE DÉCONNECTÉ POUR ACCÉDER À CETTE PAGE !
        // Vérification si un membre est en cours de connexion
        $current_member = $this->security->getUser();

        // Si oui redirection vers Homepage
        if(!is_null($current_member)) {
            return $this->redirectToRoute('blog');
        }

        $member = $repoMember->findOneByUsername($username);

        // Vérification du paramètre TOKEN
        $getToken = $request->attributes->get('_route_params');

        $token = $getToken['token'];
        // var_dump($token);
        
        /*
        if($member->getToken() != $token)
        {
            return $this->redirectToRoute('security_registration');
        }
        */

        // Attention à bien mettre le paramètre $member : " createForm(ForgotType::class, $member) "
        $forgotSecurity = $this->createForm(ForgotType::class, $member);

        $forgotSecurity->handleRequest($request);

        if($forgotSecurity->isSubmitted() && $forgotSecurity->isValid()) 
        {
            // Veiller à sécuriser l'accès à cette page avec notamment une vérification du TOKEN
            // http://localhost:8000/confirm_reset/paolo/fed334e2c0f745798e17b2539f116be94dfb5333bad6464504a1c26cdf53c56e
            if($member->getToken() === $token)
            {
                $hash = $encoder->encodePassword($member, $member->getPassword());
            
                $member->setPassword($hash);

                // $member->setNewpass('HELLO');
                
                $manager->persist($member);
    
                $manager->flush();
                
                return $this->redirectToRoute('blog');

            } else 
            {
                // Si le Token ne correspond pas, redirection vers la page d'inscription
                return $this->redirectToRoute('security_registration');
            }
           
        }

        return $this->render('security/forgot.html.twig', [
            'current_member' => $current_member,
            'forgotSecurity' => $forgotSecurity->createView()
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
