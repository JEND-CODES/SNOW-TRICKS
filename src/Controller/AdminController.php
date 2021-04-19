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
use App\Service\RemoveFile;

class AdminController extends AbstractController
{
    private $security;

    private $removeFile;

    public function __construct(Security $security, RemoveFile $removeFile)
    {
       $this->security = $security;

       $this->removeFile = $removeFile;
       
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
        if ($this->security->getUser()->getId() === $member->getId()) 
        {
            throw $this->createNotFoundException('Access Denied.');
       
        }

        $this->removeFile->deleteFile($member->getAvatar());

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
