<?php
namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCompiler;

Class CableControllerTest extends WebTestCase
{
    public function testSuccessIndex()
    {
        $client =static::createClient();

        $crawler = $client->request('GET', '/cable/');
        $this->assertEquals(302,$client->getResponse()->getStatusCode());
        $client->followRedirect();
        $this->assertEquals(200,$client->getResponse()->getStatusCode());

    }
    public function testDirection()
    {
        $client =static::createClient();

        $crawler = $client->request('GET', '/cable/new');
        $this->assertEquals(302,$client->getResponse()->getStatusCode());
        $client->followRedirect();
        $this->assertEquals(200,$client->getResponse()->getStatusCode());


        $crawler = $client->request('POST', '/cable/new');
        $this->assertEquals(302,$client->getResponse()->getStatusCode());
        $client->followRedirect();
        $this->assertEquals(200,$client->getResponse()->getStatusCode());


        $crawler = $client->request('GET', '/cable/2');
        $this->assertEquals(302,$client->getResponse()->getStatusCode());
        $client->followRedirect();
        $this->assertEquals(200,$client->getResponse()->getStatusCode());

        $crawler = $client->request('GET', '/cable/2/edit');
        $this->assertEquals(302,$client->getResponse()->getStatusCode());
        $client->followRedirect();
        $this->assertEquals(200,$client->getResponse()->getStatusCode());

        $crawler = $client->request('POST', '/cable/2');
        $this->assertEquals(302,$client->getResponse()->getStatusCode());
        $client->followRedirect();
        $this->assertEquals(200,$client->getResponse()->getStatusCode());
    }


}