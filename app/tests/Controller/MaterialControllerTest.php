<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

Class MaterialControllerTest extends WebTestCase
{
    public function testSuccessIndex()
    {
        $client =static::createClient();
        $crawler = $client->request('GET', '/material/');
        $this->assertEquals(302,$client->getResponse()->getStatusCode());
        $client->followRedirect();
        $this->assertEquals(200,$client->getResponse()->getStatusCode());

    }

    public function testDirection()
    {
        $client =static::createClient();

        $crawler = $client->request('GET', '/material/new');
        $this->assertEquals(302,$client->getResponse()->getStatusCode());
        $client->followRedirect();
        $this->assertEquals(200,$client->getResponse()->getStatusCode());

        $crawler = $client->request('POST', '/material/new');
        $this->assertEquals(302,$client->getResponse()->getStatusCode());
        $client->followRedirect();
        $this->assertEquals(200,$client->getResponse()->getStatusCode());

        $crawler = $client->request('GET', '/material/2');
        $this->assertEquals(302,$client->getResponse()->getStatusCode());
        $client->followRedirect();
        $this->assertEquals(200,$client->getResponse()->getStatusCode());

        $crawler = $client->request('GET', '/material/2/edit');
        $this->assertEquals(302,$client->getResponse()->getStatusCode());
        $client->followRedirect();
        $this->assertEquals(200,$client->getResponse()->getStatusCode());

        $crawler = $client->request('POST', '/material/2');
        $this->assertEquals(302,$client->getResponse()->getStatusCode());
        $client->followRedirect();
        $this->assertEquals(200,$client->getResponse()->getStatusCode());
    }


}