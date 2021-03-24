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
use Symfony\Component\Filesystem\Filesystem;

class AdminController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
       $this->security = $security;
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
        $filename = $member->getAvatar();

        $fileSystem = new Filesystem();

        $projectDir = $this->getParameter('kernel.project_dir');

        $fileSystem->remove($projectDir.'/public/uploads/avatars/'.$filename);

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
