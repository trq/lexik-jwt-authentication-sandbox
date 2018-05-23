<?php

declare(strict_types = 1);

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class TokenTest
 *
 * @package App\Tests
 */
class TokenTest extends WebTestCase
{
    use TokenClientTrait;

    /**
     * @test
     */
    public function canAccessAEndpointRequiringAuthentication(): void
    {
        $client = self::createClient();
        $client->request('GET', '/api');

        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $client->getResponse()->getStatusCode());

        $client = $this->createAuthenticatedClient();
        $client->request('GET', '/api');

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }
}
