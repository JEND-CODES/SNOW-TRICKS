<?php
// 0. Création BDD : php bin/console doctrine:database:create
// 1.Créer un Controller -> php bin/console make:controller
// 2. Si la BDD a déjà été créée -> Créer une nouvelle Entity : php bin/console make:entity
// 3. Renseigner les colonnes voulues pour la table SQL et faire une migration -> php bin/console make:migration (le nouveau fichier Entity est alors mis à jour)
// 4. Pour actualiser la BDD avec la nouvelle table souhaitée, faire ensuite -> php bin/console doctrine:migrations:migrate

// Mettre à jour la BDD :
// 1 -> php bin/console make:migration
// 2 -> php bin/console doctrine:migrations:migrate

// Utiliser le terminal de commande pour mettre à jour une Entité : après avoir indiqué par exemple "private $truc" avec son annotation, il suffit de faire un coup de  "php bin/console make:entity --regenerate App" et les getters/setters sont générés !
// Pour mettre ensuite à jour la BDD faire un "php bin/console doctrine:schema:update --dump-sql" puis "php bin/console doctrine:schema:update --force"

// Pour vérifier si les Entités sont conformes, qu'il n'y a notamment pas de problèmes de mappings entre Entités, faire : "php bin/console doctrine:schema:validate"

// En savoir plus sur Doctrine : https://symfony.com/doc/3.3/doctrine.html

// ROUTE NOT FOUND ? Try to clear the cache ! "php bin/console cache:clear"

// LANCER LE LIVE : php -S localhost:8000 -t public

namespace App\Controller;

    use App\Entity\Figure;

    use App\Entity\Mention;

    use App\Entity\Screen;

    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\Routing\Annotation\Route;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\Form\Extension\Core\Type\TextType;
    use Symfony\Component\Form\Extension\Core\Type\TextareaType;
    // use Symfony\Component\Form\Extension\Core\Type\SubmitType;

    // Ne marche plus dans la version Symfony 5 ?
    // Voir : problème résolu avec ObjectManager : https://openclassrooms.com/forum/sujet/symfony5-objectmanager
    // use Doctrine\Common\Persistence\ObjectManager;
    // Remplacé par : 
    use Doctrine\ORM\EntityManagerInterface;

    use App\Repository\FigureRepository;

    // IDENTIFICATION DU MEMBRE EN COURS
    // CORE\SECURITY -> UTILISÉ POUR AFFICHER LES INFORMATIONS DU MEMBRE CONNECTÉ -> ET POUR OPÉRER DES REDIRECTIONS
    // How do I get the entity that represents the current user in Symfony ?
    // https://stackoverflow.com/questions/7680917/how-do-i-get-the-entity-that-represents-the-current-user-in-symfony2
    use Symfony\Component\Security\Core\Security;


    // Pas besoin d'appeller ça ?
    // use App\Repository\MentionRepository;

    // On utilise le formulaire de Symfony pour la gestion des erreurs -> voir les modifications effectuées dans ce fichier :
    use App\Form\FigureType;

    // 23 février : révision du formatage des SLUGS
    use Symfony\Component\String\Slugger\SluggerInterface;

    use App\Form\MentionType;


class BlogController extends AbstractController
{

    private $security;

    public function __construct(Security $security)
    {
       $this->security = $security;
    }

    // PAGE D'ACCUEIL
    /**
     * @Route("/", name="blog")
     */
    public function blog(FigureRepository $repoFigure)
    {
        $current_member = $this->security->getUser();
        // $current_member = $this->getUser();

        // Requête pour l'affichage des articles en dessous du Slider en page d'accueil (limite de 6, en sautant les 3 derniers articles publiés)
        // $figures = $repoFigure->findBy(array(), array('id' => 'DESC'), 6, 3);
        $figures = $repoFigure->findBy(array(), array('id' => 'DESC'), 100, 3);
        
        // Requête pour l'affichage sur le slider en page d'accueil
        $figureSlides = $repoFigure->findBy(array(), array('id' => 'DESC'), 3);
        
        return $this->render('blog/posts.html.twig', [
            'current_member' => $current_member,
            'figures' => $figures,
            'figureSlides' => $figureSlides
        ]);
    }

    // CRÉATION D'UN ARTICLE
    /**
    * @Route("/blog/new", name="blog_create")
    */
    public function createFigure(Figure $figure = null, Request $request, EntityManagerInterface $manager, SluggerInterface $slugger)
    {
        $current_member = $this->security->getUser();
        //if(!$figure)
        //{
            $figure = new Figure();
        //}
       
        // Exemple de liaison d'une table à une autre lors de la création d'un article
        /*
        $new_mention = new Mention();
        $new_mention->setAuthor(' ');
        $new_mention->setContent(' ');
        $figure->getMentions()->add($new_mention);
        */
        // Fin de liaison

        
        // EXEMPLE DE LIAISON D'UNE TABLE À UNE AUTRE LORS DE LA CRÉATION D'UN ARTICLE (utilisation de la liaison entre ScreenType et FigureType)


/*
        // PREMIÈRE IMAGE
        // On définit une nouvelle image qui va être associée à l'article
        $new_screen_1 = new Screen();
        $new_screen_1->setThumbnail('URL image 1');
        // On appelle le GETTTER getSreens() de l'ENTITÉ FIGURE
        $figure->getScreens()->add($new_screen_1);

        // Il fallait mettre ça en plus, pour récupérer l'ID [FK] de l'article dans la colonne "figure_id" de la table Screen !!

        // Si la colonne est vide lors d'une création d'un nouvel article
        if(!$new_screen_1->getId())
        {
            // On fait appel au SETTER setFigure de l'Entité SCREEN chargée de récupérer l'ID de l'article
            $new_screen_1->setFigure($figure);
        }

        // TENTATIVE POUR UNE DEUXIÈME IMAGE
        $new_screen_2 = new Screen();
        $new_screen_2->setThumbnail('URL image 2');
        $figure->getScreens()->add($new_screen_2);

        if(!$new_screen_2->getId())
        {
            $new_screen_2->setFigure($figure);
        }
*/
        
        /*
        // GÉNÉRATION DYNAMIQUE DE FORMULAIRES
        // Comment faire en sorte que le nbr_screens (nombre d'images associées à chaque article) soit sélectionné ou informé par l'internaute ?
        if(isset($_GET['selected_screen']) && !empty($_GET['selected_screen'])){

            // $limit = (int) strip_tags($_GET['selected_screen']);
            $nbr_screens = (int) strip_tags($_GET['selected_screen']);

        }else{

            // $limit = 6;
            $nbr_screens = 4;

        }

        var_dump($_GET);
        //echo $new_limit;

        */

        // Voir comment on fait du $_GET et du $_POST dans Symfony
        // https://symfony.com/doc/current/introduction/http_fundamentals.html
        
        // $_GET -> GÉNÉRATION DYNAMIQUE DE FORMULAIRES
        $get_screen = $request->query->get('selected_screen');
        // var_dump($get_screen);

        // Si le $_GET['selected_screen'] est inexistant..
        if (is_null($get_screen))
        {
            // ..On renvoie par défaut 6 champs d'éditions d'images associées à l'article dans le formulaire..
            $nbr_screens = 6;
            // var_dump($get_screen);

        }  /* elseif ($get_screen < 6 || $get_screen > 20) {
            // Condition pour ne pas éditer mille images ou vidéos par article et les envoyer BDD !!
            // Limitations du nombre minimal ou maximal de médias (au cas où l'internaute choisirait de modifier directement le Param Get de l'URL en entrant par exemple " new?selected_screen=225580 "....)
            // On rétablit alors à 6 médias par défaut (en dessous de 6 ou au dessus de 20)
            $nbr_screens = 6;

        } */ else {

            // ..Sinon on choisit le nombre que l'on veut ! 
            // Exemple dans l'URL : " new?selected_screen=10 "
            $nbr_screens = (int) strip_tags($get_screen);
            // var_dump($get_screen);

        }


        // ICI -> ITÉRATIONS POUR LES INITIALISATIONS DU NOMBRE DE CHAMPS D'ÉDITION DES IMAGES ASSOCIÉES À L'ARTICLE DANS LE FORMULAIRE
        // $nbr_screens = 6;

        for($i = 1; $i <= $nbr_screens; $i++) {

            $dynamic_screen[$i] = new Screen();
            // ${'dynamic_screen' . $i} = new Screen();
            // $dynamic_screen = new Screen();

            $dynamic_screen[$i]->setThumbnail('');
            // $dynamic_screen[$i]->setThumbnail('/backgrounds/default_picture.jpg');
            // $dynamic_screen[$i]->setThumbnail('https://www.youtube.com/watch?v=bkugFcSWmGg&feature=emb_logo');

            // $dynamic_screen[$i]->setThumbnail('URL image_'.$i);
            // ${'dynamic_screen' . $i}->setThumbnail('URL image_'.$i);
            // $dynamic_screen->setThumbnail('URL image_'.$i);
            
            $figure->getScreens()->add($dynamic_screen[$i]);
            // $figure->getScreens()->add(${'dynamic_screen' . $i});
            // $figure->getScreens()->add($dynamic_screen);

                //if(!$dynamic_screen->getId())
                //if(!${'dynamic_screen' . $i}->getId())
                if(!$dynamic_screen[$i]->getId())
                {
                
                    // $dynamic_screen->setFigure($figure);
                    // ${'dynamic_screen' . $i}->setFigure($figure);
                    $dynamic_screen[$i]->setFigure($figure);
                }
        }

        
        // FIN DE LIAISON




        $createFigure = $this->createForm(FigureType::class, $figure);
        
        $createFigure->handleRequest($request);
        
        if($createFigure->isSubmitted() && $createFigure->isValid())
        {
            if(!$figure->getId())
            {
                $figure->setCreatedAt(new \DateTime());

                // CRÉATION SLUG & FORMATAGE SANS CARACTÈRES SPÉCIAUX + REMPLACEMENT DES ESPACES VIDES PAR DES TIRETS
                // https://stackoverflow.com/questions/2955251/php-function-to-make-slug-url-string
                // $figure->setLabelled($figure->getTitle());
                // trim() — Supprime les espaces (ou d'autres caractères) en début et fin de chaîne
                // preg_replace() — Rechercher et remplacer par expression rationnelle standard

                // $figure->setLabelled(strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $figure->getTitle() ))));

                $figure->setLabelled($slugger->slug($figure->getTitle()));

                $figure->setUser($this->getUser());
            }

            
            
            $manager->persist($figure);

            $manager->flush();

            $this->addFlash(
                'notice',
                'CRÉATION RÉUSSIE'
            );
            
            return $this->redirectToRoute('chapter_show',[
                'id' => $figure->getId(),
                'labelled' => $figure->getLabelled()
            ]);
        }
        
        return $this->render('blog/createChapter.html.twig',[
            //'figure' => $figure,
            'current_member' => $current_member,
            'createFigure' => $createFigure->createView()
        ]);
        
    }

    // MISE À JOUR D'UN ARTICLE
    /**
    * @Route("/blog/{id}/edit", name="blog_edit")
    */
    public function updateFigure(Figure $figure, Request $request, EntityManagerInterface $manager, SluggerInterface $slugger)
    {
        $current_member = $this->security->getUser();
        /*
        if(!$figure)
        {
            $figure = new Figure();
        }
        */

        // Exemple de liaison d'une table à une autre lors de la création d'un article
        /*
        $new_mention = new Mention();
        $new_mention->setAuthor(' ');
        $new_mention->setContent(' ');
        $figure->getMentions()->add($new_mention);
        */
        // Fin de liaison
       
        $updateFigure = $this->createForm(FigureType::class, $figure);
        
        $updateFigure->handleRequest($request);
        
        if($updateFigure->isSubmitted() && $updateFigure->isValid())
        {
            /*
            if(!$figure->getId())
            {
                $figure->setCreatedAt(new \DateTime());
            }
            */
            $figure->setFreshDate(new \DateTime());

            // MISE À JOUR SLUG & FORMATAGE SANS CARACTÈRES SPÉCIAUX + REMPLACEMENT DES ESPACES VIDES PAR DES TIRETS
            // https://stackoverflow.com/questions/2955251/php-function-to-make-slug-url-string
            // $figure->setLabelled($figure->getTitle());
            // trim() — Supprime les espaces (ou d'autres caractères) en début et fin de chaîne
            // preg_replace() — Rechercher et remplacer par expression rationnelle standard

            // $figure->setLabelled(strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $figure->getTitle() ))));

            $figure->setLabelled($slugger->slug($figure->getTitle()));
            
            $manager->persist($figure);

            $manager->flush();

            $this->addFlash(
                'notice',
                'MISE À JOUR RÉUSSIE'
            );
            
            return $this->redirectToRoute('chapter_show',[
                'id' => $figure->getId(),
                'labelled' => $figure->getLabelled()
            ]);
        }
        
        return $this->render('blog/updateChapter.html.twig',[
            'current_member' => $current_member,
            'figure' => $figure,
            'updateFigure' => $updateFigure->createView()
        ]);
        
        
    }


   // 24 octobre -> // Erreur Entity was not found ? J'ai supprimé la mention "Mention $mention" dans les paramètres de la fonction, car je me retrouvai sans cesse avec le message "App\Entity\Mention not found by @paramConvert annotation" 
   // LECTURE D'UN ARTICLE ET AJOUTS DE COMMENTAIRES
   /**
     * @Route("/blog/{id}/{labelled}", name="chapter_show")
     */
    public function show(Figure $figure, Request $request, string $labelled)
    {

        $current_member = $this->security->getUser();

        // PAGINATION DES COMMENTAIRES
        $get_mentions = $request->query->get('show_mentions');

        if (is_null($get_mentions))
        {
        
            $start = 0;
            $limit = 5;

        } else {

            $start = (int) strip_tags($get_mentions);
            $limit = 5;
            
        }
        // FIN DE PAGINATION


        // ENREGISTREMENTS DES COMMENTAIRES
        $mention = new Mention();

        $formMention = $this->createForm(MentionType::class, $mention);
        
        $formMention->handleRequest($request);
        
        /*
        $formMention = $this->createFormBuilder($mention)
                
                // ->add('author')
                ->add('content')

                // 3 février -> On peut simplement mettre un "Button type Submit" au coeur du formulaire pour l'activer (ici j'ai désactivé le bouton, j'en ai placé un dans le fichier TWIG et j'ai désactivé la dépendance en haut de BlogController -> use..\SubmitType)
                 
                // ->add('save', SubmitType::class, array(
                    // 'label' => 'Publier'        
                // ))
                
                
                ->getForm();
            
        $formMention->handleRequest($request);
        */
            
        if($formMention->isSubmitted() && $formMention->isValid()) 
        {
            if(!$mention->getId())
                {
                    $mention->setCreatedAt(new \DateTime());
                
                    $mention->setFigure($figure);

                    // 12 février -> Enregistrement du Membre auteur du commentaire
                    // It Works !!
                    $mention->setUser($this->getUser());
                }
            
            $mention = $formMention->getData();
            
            $entityManager = $this->getDoctrine()->getManager();
            
            $entityManager->persist($mention);
            
            $entityManager->flush();

            $this->addFlash(
                'notice',
                'COMMENTAIRE AJOUTÉ'
            );
        
            return $this->redirect($request->getUri());
        }

        return $this->render('blog/oneChapter.html.twig', array(
            'current_member' => $current_member,
            'limit' => $limit,
            'start' => $start,
            'figure' => $figure,
            'labelled' => $figure->getLabelled(),
            'formMention' => $formMention->createView()
        ));
        
    }
    
    /**
     * @Route("/blog/{id}/{start}", name="mention_paging", requirements={"start": "\d+"})
     */
    /*
    public function mentionPaging(FigureRepository $repoFigure, $id, $start = 5)
    {
        $figure = $repoFigure->findOneById($id);

        return $this->render('inc/mentionPaging.html.twig', [
            'figure' => $figure,
            'start' => $start
        ]);
    }
    */
    
    
    // SUPPRESSION D'UN ARTICLE
    /**
     * @Route("/office/delete/{id}", name="delete_chapter")
     * @Method({"DELETE"})
     */
    public function delete(Figure $figure) 
    {
        // Method Delete
        $entityManager = $this->getDoctrine()->getManager();
        /*
        $figure = $entityManager->getRepository(Figure::class)->find($id);
        */
        $entityManager->remove($figure);
        
        $entityManager->flush();

        $this->addFlash(
            'notice',
            'SUPPRESSION RÉALISÉE'
        );


        /*
        $response = new Response();
        
        $response->send();
        */

        // return $this->redirect($this->generateUrl('office'));
        return $this->redirect($this->generateUrl('blog'));
        
        // Chercher le moyen de rafraîchir les pages de la pagination...??
        
        // return $this->redirectToRoute('office');
                /*
                // Page avec pagination des articles
                $chapters = $repoChapter->findAll();
        
                // Intégration dans la fonction DELETE de la fonction "chapterBackOffice" avec Paginator :
                $queryList = $this->getDoctrine()->getManager();

                $backChapter = $queryList->getRepository(Chapter::class);

                $chapterQB = $backChapter->createQueryBuilder('o')
                    ->getQuery();

                $backlists = $paginator->paginate(
                    $chapterQB,
                    $request->query->getInt('page', 1),
                    6,
                    [
                    'defaultSortFieldName' => 'o.id',
                    'defaultSortDirection' => 'desc',
                    ]
                );
                // Fin d'intégration de la fonction "chapterBackOffice" avec Paginator
        
       return $this->render('paging/backOffice.html.twig', array('chapters' => $chapters, 'backlists' => $backlists));
       */
    }
    
    
    
   

    
    
   

    
}
