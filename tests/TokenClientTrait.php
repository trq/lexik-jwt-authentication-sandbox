<?php

declare(strict_types = 1);

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Client;

/**
 * Trait TokenClientTrait
 *
 * @package App\Tests
 */
trait TokenClientTrait
{
    /**
     * Create a client with a default Authorization header.
     *
     * @param string $username
     * @param string $password
     *
     * @return Client
     */
    protected function createAuthenticatedClient(?string $username = null, ?string $password = null)
    {
        /** @var Client $client */
        $client = static::createClient();

        $username = uniqid('test', true);

        $client->request(
            'POST',
            '/register',
            [
                '_username' => $username,
                '_password' => 'password',
            ]
        );

        $data = json_decode($client->getResponse()->getContent(), true);

        $client->request(
            'POST',
            '/login_check',
            [
                '_username' => $username,
                '_password' => 'password',
            ]
        );

        $data = json_decode($client->getResponse()->getContent(), true);

        var_export($data);

        $client = static::createClient();

        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', trim($data['token'])));

        return $client;
    }
}
