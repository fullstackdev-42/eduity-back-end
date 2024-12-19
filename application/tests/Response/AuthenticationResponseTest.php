<?php

namespace App\Tests\Response;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class AuthenticationResponseTest extends WebTestCase
{

    /**
     * Create a client with a default Authorization header.
     *
     * @param string $email
     * @param string $password
     *
     * @return \Symfony\Bundle\FrameworkBundle\Client
     */
    protected function createAuthenticatedClient($email, $password)
    {
        self::ensureKernelShutdown();
        $client = self::createClient();
        $client->request(
            'POST',
            '/v1/login',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(['email' => $email, 'password' => $password])
        );

        $data = json_decode($client->getResponse()->getContent(), true);

        self::ensureKernelShutdown();
        $client = self::createClient();
        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['token']));

        return $client;
    }

    /**
     * test getPagesAction
     */
    public function testGetPages()
    {
        $client = $this->createAuthenticatedClient($_ENV['TEST_USER_EMAIL'], $_ENV['TEST_USER_PASSWORD']);
        $client->request('GET', '/v1/users');

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Failed to JWT authenticate!");
    }

}