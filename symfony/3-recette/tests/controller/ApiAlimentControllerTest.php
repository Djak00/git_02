<?php

namespace App\tests\controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiAlimentControllerTest extends WebTestCase
{
    public function testGetAlimentParId(): void
    {
        $client = static::createClient();

        $client->request('GET', '/api/aliment/1');

        $this->assertResponseIsSuccessful();

        $this->assertStringContainsString('Carotte', $client->getResponse()->getContent());
    }
}