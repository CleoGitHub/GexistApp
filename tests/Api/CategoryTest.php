<?php


namespace App\Tests\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CategoryTest extends WebTestCase
{
    public function testGet()
    {
        $client = self::createClient();
        $crawler = $client->request(
            'GET',
            'api/categories',
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
            ]
        );
        $responses = $client->getResponse();
        $content = json_decode($responses->getContent());

        dd($content);
    }
}