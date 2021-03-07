<?php

namespace Tests\Func;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Repository\MemberRepository;

class ControllerTest extends WebTestCase
{
	public function testHomePage()
    {
        $client = static::createClient();

        $client->request('GET', '/');

        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();

        $this->assertSame(1, $crawler->filter('html:contains("SNOWTRICKS")')->count());

    }

    public function testErrorPage()
    {
        $client = static::createClient();

        $client->request('GET', '/azerty');

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

        $testUser = $memberRepo->findOneByEmail('jean@gmail.com');

        $client->loginUser($testUser);

        $client->request('GET', '/admin/backoff');
        
        $this->assertResponseIsSuccessful();
    }
    
    public function testErrorToken()
    {
        $client = static::createClient();

        $client->request('GET', '/confirm_reset/jean/r2f3d21sj1h6h8y4h654g8641k');

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

        $client->loginUser($member);

        $client->followRedirects();

        $crawler = $client->request('GET', '/blog/30/rocket-air');

        $form = $crawler->selectButton('Publier')->form();

        $form['mention[content]'] = 'Nouveau commentaire';

        $crawler = $client->submit($form);
        
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertSame(1, $crawler->filter('html:contains("Nouveau commentaire")')->count());

    }


}
