<?php

namespace Tests\Func;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Repository\MemberRepository;

//**** Effectuer un test fonctionnel
// Créer un client HTTP.
// Effectuer une requête HTTP sur la page que nous devons tester.
// S'assurer que les éléments sur la page testée sont bien présents (écrire des assertions).
//****

// Obtenir la liste des routes de l'application : php bin/console debug:router

class ControllerTest extends WebTestCase
{
	public function testHomePage()
    {
        $client = static::createClient();

        $client->request('GET', '/');

        $crawler = $client->request('GET', '/');

        // $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertResponseIsSuccessful();

        $this->assertSame(1, $crawler->filter('html:contains("SNOWTRICKS")')->count());

    }

    public function testErrorPage()
    {
        $client = static::createClient();

        $client->request('GET', '/azerty');

        // $this->assertTrue($client->getResponse()->isNotFound());
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    public function testRedirect()
    {
        $client = static::createClient();

        $client->request('GET', '/disconnect');

        $this->assertResponseRedirects();
    }

    public function testAdminAccess()
    {
        $client = static::createClient();

        $container = $client->getContainer();

        $memberRepo = static::$container->get(MemberRepository::class);

        // Administrateur -> ROLE_ADMIN (autorisation d'accès en Back Office)
        $testUser = $memberRepo->findOneByEmail('jean@gmail.com');

        // Membre -> ROLE_USER (accès interdit en Back Office)
        // $testUser = $memberRepo->findOneByEmail('vincent@gmail.com');

        // Simulation de connexion du membre Admin
        $client->loginUser($testUser);

        // test e.g. the profile page
        $client->request('GET', '/admin/backoff');
        
        $this->assertResponseIsSuccessful();
    }
    
    public function testErrorToken()
    {
        $client = static::createClient();

        // Faux Token
        $client->request('GET', '/confirm_reset/jean/r2f3d21sj1h6h8y4h654g8641k');
        // $client->request('GET', '/');

        $this->assertResponseRedirects();
    }

    public function testConnexionForm()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/connexion');

        $form = $crawler->selectButton('Connexion')->form();

        $form['_username'] = 'member';
        $form['_password'] = 'password';

        $crawler = $client->submit($form);

        $this->expectNotToPerformAssertions();

    }

    public function testNewMention()
    {
        $client = static::createClient();

        $memberRepo = static::$container->get(MemberRepository::class);

        $member = $memberRepo->findOneByEmail('jean@gmail.com');

        // Si le membre n'est pas connecté il ne pourra pas commenter !
        $client->loginUser($member);

        $client->followRedirects();

        // Si la route n'est pas bonne erreur ! ex : '/blog/rocket-air'
        $crawler = $client->request('GET', '/blog/30/rocket-air');

        $form = $crawler->selectButton('Publier')->form();

        $form['mention[content]'] = 'Nouveau commentaire';

        $crawler = $client->submit($form);
        
        // Une réponse réussie renvoie le code status 200
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        // Vérification que la page contient bien le nouveau commentaire
        $this->assertSame(1, $crawler->filter('html:contains("Nouveau commentaire")')->count());

    }


}
