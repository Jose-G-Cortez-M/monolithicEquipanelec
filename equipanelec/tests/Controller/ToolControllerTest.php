<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

Class ToolControllerTest extends WebTestCase
{
    public function testSuccessIndex()
    {
        $client =static::createClient();
        $crawler = $client->request('GET', '/tool/');
        $this->assertEquals(302,$client->getResponse()->getStatusCode());
        $client->followRedirect();
        $this->assertEquals(200,$client->getResponse()->getStatusCode());

    }

    public function testDirection()
    {
        $client =static::createClient();

        $crawler = $client->request('GET', '/tool/new');
        $this->assertEquals(302,$client->getResponse()->getStatusCode());
        $client->followRedirect();
        $this->assertEquals(200,$client->getResponse()->getStatusCode());

        $crawler = $client->request('POST', '/tool/new');
        $this->assertEquals(302,$client->getResponse()->getStatusCode());
        $client->followRedirect();
        $this->assertEquals(200,$client->getResponse()->getStatusCode());


        $crawler = $client->request('GET', '/tool/2');
        $this->assertEquals(302,$client->getResponse()->getStatusCode());
        $client->followRedirect();
        $this->assertEquals(200,$client->getResponse()->getStatusCode());

        $crawler = $client->request('GET', '/tool/2/edit');
        $this->assertEquals(302,$client->getResponse()->getStatusCode());
        $client->followRedirect();
        $this->assertEquals(200,$client->getResponse()->getStatusCode());

        $crawler = $client->request('POST', '/tool/2');
        $this->assertEquals(302,$client->getResponse()->getStatusCode());
        $client->followRedirect();
        $this->assertEquals(200,$client->getResponse()->getStatusCode());
    }



}