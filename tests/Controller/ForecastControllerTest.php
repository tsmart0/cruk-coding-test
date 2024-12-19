<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class ForecastControllerTest extends WebTestCase
{
    public function testSuccessfulResponse(): void
    {
        // The Symfony WebTestCase allows you to send HTTP requests and assert the response.
        $client = ForecastControllerTest::createClient();
        $client->request('GET', '/forecast');
        // This checks that the response status code was >= 200.
        $this->assertResponseIsSuccessful();
        // Checking the content in the response is a valid JSON string.
        $content = $client->getResponse()->getContent();
        $this->assertJson($content);
    }
}