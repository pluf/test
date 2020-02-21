<?php
declare(strict_types = 1);

use Pluf\Test\TestCase;

final class TestCaseTest extends TestCase
{

    /**
     *
     * @test
     */
    public function newInstanceMustSetGlobalVariablesOfPluf(): void
    {
        // Create instance
        new TestCase();

        // Check vars
        $this->assertArrayHasKey('_PX_starttime', $GLOBALS);
        $this->assertArrayHasKey('_PX_uniqid', $GLOBALS);
        $this->assertArrayHasKey('_PX_signal', $GLOBALS);
        $this->assertArrayHasKey('_PX_locale', $GLOBALS);
    }
}