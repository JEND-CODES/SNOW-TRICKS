<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use App\Entity\Mention;
use App\Entity\Member;
use App\Repository\FigureRepository;
use App\Repository\MentionRepository;
use App\Repository\MemberRepository;

// use Symfony\Component\Filesystem\Filesystem;
use App\Service\RemoveFile;

class AdminController extends AbstractController
{
    private $security;

    private $remover;

    public function __construct(Security $security, RemoveFile $remover)
    {
       $this->security = $security;

       $this->remover = $remover;

    }

    /**
     * @Route("/admin/backoff", name="admin_backoff")
     */
    public function backOff(FigureRepository $repoFigure) 
    {
        $current_member = $this->security->getUser();

        $articles = $repoFigure->findBy(array(), array('id' => 'desc'));
        
        return $this->render('admin/backOffice.html.twig', [
            'current_member' => $current_member,
            'articles' => $articles
        ]);

    }

    /**
     * @Route("/admin/backcom", name="admin_backcom")
     */
    public function backCom(MentionRepository $repoMention)
    {
        $current_member = $this->security->getUser();

        $comments = $repoMention->findBy(array(), array('id' => 'desc'));
     
        return $this->render('admin/commentOffice.html.twig', [
            'current_member' => $current_member,
            'comments' => $comments
        ]);
    }
    
    /**
     * @Route("/admin/backcom/delete/{id}", name="delete_comment")
     * @Method({"DELETE"})
     */
    public function deleteComment(Mention $mention)
    {
        $entityManager = $this->getDoctrine()->getManager();
        
        $entityManager->remove($mention);
        
        $entityManager->flush();

        $this->addFlash(
            'notice',
            'COMMENTAIRE SUPPRIMÉ'
        );
        
        return $this->redirect($this->generateUrl('admin_backcom'));
        
    }

    /**
     * @Route("/admin/members", name="manage_members")
     */
    public function manageMembers(MemberRepository $repoMember)
    {
        $current_member = $this->security->getUser();

        $members = $repoMember->findBy(array(), array('id' => 'desc'));
     
        return $this->render('admin/members.html.twig', [
            'current_member' => $current_member,
            'members' => $members
        ]);
        
    }

    /**
     * @Route("/admin/members/delete/{id}", name="delete_member")
     * @Method({"DELETE"})
     */
    public function deleteMember(Member $member)
    {

        // POUR EMPÊCHER UN ADMINISTRATEUR DE SUPPRIMER SON PROPRE COMPTE !
        if ($this->security->getUser()->getId() === $member->getId()) 
        {
            throw $this->createNotFoundException('Access Denied.');
            // $errorMessage = 'Administrateur ne va pas supprimer son compte !';
            // dd($errorMessage);
        }

        // $filename = $member->getAvatar();

        // Tenter de mettre un service de suppression à la place

        // CE QUE JE REMPLACE PAR LE SERVICE :
        // $fileSystem = new Filesystem();

        // $projectDir = $this->getParameter('kernel.project_dir');

        // $fileSystem->remove($projectDir.'/public/uploads/avatars/'.$filename);

        // CE QUE JE FAIS VIA LE SERVICE :
        // $this->remover->deleteFile($filename);

        // OU PLUS SIMPLE ENCORE ! :
        $this->remover->deleteFile($member->getAvatar());


        $entityManager = $this->getDoctrine()->getManager();
        
        $entityManager->remove($member);
        
        $entityManager->flush();

        $this->addFlash(
            'notice',
            'MEMBRE SUPPRIMÉ'
        );
        
        return $this->redirect($this->generateUrl('manage_members'));
        
    }
    
}
