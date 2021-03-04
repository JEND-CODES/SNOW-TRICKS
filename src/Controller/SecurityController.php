<?php

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
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{

    private $security;

    public function __construct(Security $security)
    {
       $this->security = $security;
    }
    
    /**
     * @Route("/inscription", name="security_registration")
     */
    public function registration(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder, MailerInterface $mailer, SluggerInterface $slugger)
    {
        $current_member = $this->security->getUser();

        if(!is_null($current_member)) {
            return $this->redirectToRoute('blog');
        }

        $member = new Member();
        
        $formSecurity = $this->createForm(MemberType::class, $member);
        
        $formSecurity->handleRequest($request);
        
        if($formSecurity->isSubmitted() && $formSecurity->isValid())
        {
            $avatarFile = $formSecurity->get('avatar')->getData();

            if ($avatarFile) {
                $originalFilename = pathinfo($avatarFile->getClientOriginalName(), PATHINFO_FILENAME);
                
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$avatarFile->guessExtension();

                try {
                    $avatarFile->move(
                        $this->getParameter('avatars_directory'),
                        $newFilename
                    );

                } catch (FileException $e) {
                    $this->addFlash(
                        'warning',
                        'IMAGE INVALIDE'
                    );

                    return $this->redirectToRoute('security_registration');

                }

                $member->setAvatar($newFilename);

            }
            
            $hash = $encoder->encodePassword($member, $member->getPassword());
            
            $member->setPassword($hash)
                    ->setCreatedAt(new \DateTime)
                    ->setToken(hash('sha256', random_bytes(10)))
                    ->setValidation(false)
                    ->setRole('ROLE_USER')
                    ;

            $manager->persist($member);

            $manager->flush();

            $email = (new TemplatedEmail())
                ->from('noreply@snowtricks.com')
                ->to(new Address($member->getEmail()))
                ->subject('CONFIRMATION DE VOTRE COMPTE SNOWTRICKS')
                ->htmlTemplate('emails/validation.html.twig')
                ->context([
                    'member' => $member
                ])
                ;

            $mailer->send($email);

            $this->addFlash(
                'notice',
                'Un email vous a été adressé pour confirmer votre compte'
            );

            return $this->redirectToRoute('blog');
            
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

        if($token !== null && $token === $member->getToken())
        {
            $member->setValidation(true);

            $manager->persist($member);

            $manager->flush();

            $this->addFlash(
                'notice',
                'COMPTE VALIDÉ'
            );

        } 
        else
        {
            return $this->redirectToRoute('security_registration');
        }

        return $this->redirectToRoute('security_connexion'); 
    }

    /**
     * @Route("/newpass", name="new_password")
     */
    public function updatePass(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
        $current_member = $this->security->getUser();

        if($current_member === null)
        {
            return $this->redirectToRoute('security_connexion');

        } 
  
        $formNewpass = $this->createForm(NewpassType::class, $current_member);
        
        $formNewpass->handleRequest($request);
    
        if($formNewpass->isSubmitted() && $formNewpass->isValid())
        {
          
                $hash = $encoder->encodePassword($current_member, $current_member->getPassword());
                
                $current_member->setPassword($hash);
                
                $manager->persist($current_member);

                $manager->flush();

                $this->addFlash(
                    'notice',
                    'NOUVEAU PASSWORD ENREGISTRÉ'
                );

            
            return $this->redirectToRoute('blog');
        }
    
        return $this->render('security/newpass.html.twig', [
            'formNewpass' => $formNewpass->createView(),
            'current_member' => $current_member
        ]);
    }
    
    /**
     * @Route("/resetpass", name="reset_password")
     */
    public function resetPass(Request $request, EntityManagerInterface $manager, MemberRepository $repoMember, MailerInterface $mailer)
    {
        $current_member = $this->security->getUser();

        // Si oui redirection vers Homepage
        if(!is_null($current_member)) {
            return $this->redirectToRoute('blog');
        }

        $member = new Member();
 
        $resetSecurity = $this->createForm(ResetType::class);

        $resetSecurity->handleRequest($request);

        if($resetSecurity->isSubmitted() && $resetSecurity->isValid()) 
        {
            $username = $resetSecurity->getData('username');

            $member = $repoMember->findOneBy(array('username' => $username->getUsername()));

            if(!$member){
                
                $this->addFlash(
                    'warning',
                    'PSEUDO NON RECONNU'
                );

                return $this->redirectToRoute('reset_password');
            }

            if($member !== null)
            {
                $member->setToken(hash('sha256', random_bytes(10)));

                $manager->persist($member);

                $manager->flush();

                $email = (new TemplatedEmail())
                    ->from('noreply@snowtricks.com')
                    ->to(new Address($member->getEmail()))
                    ->subject('RÉINITIALISATION DE VOTRE MOT PASSE SNOWTRICKS')
                    ->htmlTemplate('emails/diepass.html.twig')
                    ->context([
                        'member' => $member
                    ])
                    ;

                $mailer->send($email);

                $this->addFlash(
                    'notice',
                    'Un email vous a été adressé pour procéder à la création d\'un nouveau mot de passe'
                );
                return $this->redirectToRoute('blog');
                
            }
           
        }

        return $this->render('security/reset.html.twig', [
            'current_member' => $current_member,
            'resetSecurity' => $resetSecurity->createView(),
            'member' => $member
        ]);
    }

    /**
     * @Route("/confirm_reset/{username}/{token}", name="confirm_reset")
     */
    public function confirmReset(Request $request, MemberRepository $repoMember, UserPasswordEncoderInterface $encoder, EntityManagerInterface $manager, $username, $token)
    {
        $current_member = $this->security->getUser();

        if(!is_null($current_member)) {
            return $this->redirectToRoute('blog');
        }

        $member = $repoMember->findOneByUsername($username);

        $getToken = $request->attributes->get('_route_params');

        $token = $getToken['token'];
        
        if($member->getToken() != $token)
        {
            return $this->redirectToRoute('blog');
        }
        
        $forgotSecurity = $this->createForm(ForgotType::class, $member);

        $forgotSecurity->handleRequest($request);

        if($forgotSecurity->isSubmitted() && $forgotSecurity->isValid()) 
        {
            if($member->getToken() === $token)
            {
                $hash = $encoder->encodePassword($member, $member->getPassword());
            
                $member->setPassword($hash);
                
                $manager->persist($member);
    
                $manager->flush();

                $this->addFlash(
                    'notice',
                    'NOUVEAU PASSWORD ENREGISTRÉ'
                );
                
                return $this->redirectToRoute('blog');

            } else 
            {
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
    public function connexion(AuthenticationUtils $utils)
    {
        $current_member = $this->security->getUser();

        if(!is_null($current_member)) {
            return $this->redirectToRoute('blog');
        }

        $error = $utils->getLastAuthenticationError();

        return $this->render('security/connexion.html.twig', [
            'error' => $error,
            'current_member' => $current_member
        ]);
    }
    
    /**
     * @Route("/disconnect", name="security_disconnect")
     */
    public function disconnect() {}
    
}
