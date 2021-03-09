<?php


namespace App\Tests\Api;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class CategoryTest extends ApiTestCase
{
    public function getCategories()
    {
        $client = self::createClient();
        return $client->request(
            'GET',
            '/api/categories',
            [
                'headers' => [
                    'accept' => 'application/json'
                ]
            ]
        );
    }
    public function getCategory()
    {
        $client = self::createClient();
        return $client->request(
            'GET',
            '/api/categories/1',
            [
                'headers' => [
                    'accept' => 'application/json'
                ]
            ]
        );
    }

    public function testValidGetCategories()
    {
        $this->getCategories();
        $this->assertResponseIsSuccessful();
    }

    public function testGetCategory()
    {
        $this->getCategory();
        $this->assertResponseIsSuccessful();
    }

    public function testGetName()
    {
        $response = $this->getCategory();
        $category = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('name', $category);
    }

    public function testGetSubcategories()
    {
        $response = $this->getCategory();
        $category = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('subcategories', $category);
    }

    public function testPostNotValid()
    {
        $client = self::createClient();
        $client->request(
            'POST',
            '/api/categories',
            [
                'json' => [
                    'name' => 'Category Invalid'
                ]
            ]
        );
        $this->assertResponseStatusCodeSame(405);
    }
}