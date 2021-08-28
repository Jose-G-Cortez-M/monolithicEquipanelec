<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

Class Project_closeControllerTest extends WebTestCase
{
    public function testSuccessIndex()
    {
        $client =static::createClient();
        $crawler = $client->request('GET', '/project/close/');
        $this->assertEquals(302,$client->getResponse()->getStatusCode());
        $client->followRedirect();
        $this->assertEquals(200,$client->getResponse()->getStatusCode());

    }
    public function testDirection()
    {
        $client =static::createClient();


        $crawler = $client->request('GET', '/project/close/2');
        $this->assertEquals(302,$client->getResponse()->getStatusCode());
        $client->followRedirect();
        $this->assertEquals(200,$client->getResponse()->getStatusCode());

        $crawler = $client->request('POST', '/project/close/2');
        $this->assertEquals(302,$client->getResponse()->getStatusCode());
        $client->followRedirect();
        $this->assertEquals(200,$client->getResponse()->getStatusCode());
    }



}