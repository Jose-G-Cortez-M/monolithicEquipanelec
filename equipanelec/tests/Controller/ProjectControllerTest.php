<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

Class ProjectControllerTest extends WebTestCase
{
    public function testSuccessIndex()
    {
        $client =static::createClient();
        $crawler = $client->request('GET', '/project/');
        $this->assertEquals(302,$client->getResponse()->getStatusCode());
        $client->followRedirect();
        $this->assertEquals(200,$client->getResponse()->getStatusCode());

    }
    public function testDirection()
    {
        $client =static::createClient();

        $crawler = $client->request('GET', '/project/new');
        $this->assertEquals(302,$client->getResponse()->getStatusCode());
        $client->followRedirect();
        $this->assertEquals(200,$client->getResponse()->getStatusCode());

        $crawler = $client->request('POST', '/project/new');
        $this->assertEquals(302,$client->getResponse()->getStatusCode());
        $client->followRedirect();
        $this->assertEquals(200,$client->getResponse()->getStatusCode());


        $crawler = $client->request('GET', '/project/2');
        $this->assertEquals(302,$client->getResponse()->getStatusCode());
        $client->followRedirect();
        $this->assertEquals(200,$client->getResponse()->getStatusCode());

        $crawler = $client->request('GET', '/project/2/edit');
        $this->assertEquals(302,$client->getResponse()->getStatusCode());
        $client->followRedirect();
        $this->assertEquals(200,$client->getResponse()->getStatusCode());

        $crawler = $client->request('POST', '/project/2');
        $this->assertEquals(302,$client->getResponse()->getStatusCode());
        $client->followRedirect();
        $this->assertEquals(200,$client->getResponse()->getStatusCode());
    }



}