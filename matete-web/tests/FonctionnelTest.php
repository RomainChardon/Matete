<?php
use App\Repository\ProducteurRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class ProfileControllerTest extends WebTestCase
{
    
    public function testVisitingWhileLoggedIn()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(ProducteurRepository::class);
        // retrieve the test user
        $testUser = $userRepository->findOneByMail('jdonet@test.fr');
        // simulate $testUser being logged in
        $client->loginUser($testUser);
        // test e.g. the profile page
        $client->request('GET', '/panel/annonce/new');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Ajouter un annonce');
    }
    public function testErreurAuth():void
    {
        $client = static::createClient();
        // test e.g. the profile page
        $crawler = $client->request('GET', '/panel/producteur');
        $this->assertResponseStatusCodeSame(401);
        //$this->assertSelectorTextContains('h1', 'Hello John!');
    }
}