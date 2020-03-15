<?php
declare(strict_types = 1);

use Pluf\Test\TestCase;
use Pluf\Test\Client;

final class ClientTest extends TestCase
{

    /**
     * 
     * 
     * @test
     */
    public function canCreateNewInstanceOfClientEveryTime(): void
    {
        $client = new Client(array());
        $this->assertNotNull($client, 'Impossilbe to create a client');
    }
}