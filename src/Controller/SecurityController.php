<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Member;
use App\Form\MemberType;
use App\Repository\MemberRepository;
use App\Form\NewpassType;
use App\Form\ResetType;
use App\Form\ForgotType;
use App\Form\ProfileType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Service\FileUploader;
use App\Service\RemoveFile;
use App\Service\MailSender;

class SecurityController extends AbstractController
{
    /**
     * @var Security
     */
    private $security;

    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * @var FileUploader
     */
    private $uploadFile;

    /**
     * @var RemoveFile
     */
    private $removeFile;

    /**
     * @var MailSender
     */
    private $mailSender;

    public function __construct(
        Security $security, 
        EntityManagerInterface $manager, 
        UserPasswordEncoderInterface $encoder, 
        FileUploader $uploadFile, 
        RemoveFile $removeFile, 
        MailSender $mailSender
        )
    {
        $this->security = $security;
        $this->manager = $manager;
        $this->encoder = $encoder;
        $this->uploadFile = $uploadFile;
        $this->removeFile = $removeFile;
        $this->mailSender = $mailSender;
    }
    
    /**
     * @Route("/inscription", name="security_registration", methods={"GET","POST"})
     * @param Request $request
     * @param SluggerInterface $slugger
     * @return Response
     */
    public function registration(Request $request, SluggerInterface $slugger): Response
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

                $newFilename = $this->uploadFile->upload($avatarFile);

                $member->setAvatar($newFilename);

            }
            
            $hash = $this->encoder->encodePassword($member, $member->getPassword());
            
            $member->setPassword($hash)
                    ->setCreatedAt(new \DateTime)
                    ->setToken(hash('sha256', random_bytes(10)))
                    ->setValidation(false)
                    ->setRole('ROLE_USER')
                    ;

            $this->manager->persist($member);

            $this->manager->flush();

            $templateName = 'validation';

            $this->mailSender->sendMail($member->getEmail(), $member, $this->mailSender::NEW_ACCOUNT_TITLE, "emails/".$templateName.".html.twig");

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
     * @Route("/confirm_account/{username}/{token}", name="confirm_account", requirements={"username": ".*", "token": ".*"}, methods={"GET","POST"})
     * @param MemberRepository $repoMember
     * @param string $username
     * @param string $token
     * @return RedirectResponse
     */
    public function confirmAccount(MemberRepository $repoMember, string $username, string $token): RedirectResponse
    {

        $member = $repoMember->findOneByUsername($username);

        if($token !== null && $token === $member->getToken())
        {
            $member->setValidation(true);

            $this->manager->persist($member);

            $this->manager->flush();

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
     * @Route("/newpass", name="new_password", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function updatePass(Request $request): Response
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
          
                $hash = $this->encoder->encodePassword($current_member, $current_member->getPassword());
                
                $current_member->setPassword($hash);
                
                $this->manager->persist($current_member);

                $this->manager->flush();

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
     * @Route("/resetpass", name="reset_password", methods={"GET","POST"})
     * @param Request $request
     * @param MemberRepository $repoMember
     * @return Response
     */
    public function resetPass(Request $request, MemberRepository $repoMember): Response
    {
        $current_member = $this->security->getUser();

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

                $this->manager->persist($member);

                $this->manager->flush();

                $templateName = 'diepass';

                $this->mailSender->sendMail($member->getEmail(), $member, $this->mailSender::NEW_PASSWORD_TITLE, "emails/".$templateName.".html.twig");

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
     * @Route("/confirm_reset/{username}/{token}", name="confirm_reset", requirements={"username": ".*", "token": ".*"}, methods={"GET","POST"})
     * @param Request $request
     * @param MemberRepository $repoMember
     * @param string $username
     * @param string $token
     * @return Response
     */
    public function confirmReset(Request $request, MemberRepository $repoMember, string $username, string $token): Response
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
                $hash = $this->encoder->encodePassword($member, $member->getPassword());
            
                $member->setPassword($hash);
                
                $this->manager->persist($member);
    
                $this->manager->flush();

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
     * @Route("/connexion", name="security_connexion", methods={"GET","POST"})
     * @param AuthenticationUtils $utils
     * @return Response
     */
    public function connexion(AuthenticationUtils $utils): Response
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
     * @Route("/account", name="account", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function account(Request $request): Response
    {
        $current_member = $this->security->getUser();

        $current_avatar = $this->security->getUser()->getAvatar();

        if($current_member === null)
        {
            return $this->redirectToRoute('security_connexion');

        } 

        $profileForm = $this->createForm(ProfileType::class, $current_member);

        $profileForm->handleRequest($request);

        if($profileForm->isSubmitted() && $profileForm->isValid()) 
        {
            $this->removeFile->deleteFile($current_avatar);
            
            $avatarFile = $profileForm->get('avatar')->getData();

            if ($avatarFile) {

                $avatarFileName = $this->uploadFile->upload($avatarFile);

                $current_member->setAvatar($avatarFileName);

            }

            $this->manager->persist($current_member);

            $this->manager->flush();

            $this->addFlash(
                'notice',
                'COMPTE MIS À JOUR'
            );
            
            return $this->redirectToRoute('blog');

        }

        return $this->render('security/account.html.twig', [
            'current_member' => $current_member,
            'profileForm' => $profileForm->createView()
        ]);

    }

    
}
