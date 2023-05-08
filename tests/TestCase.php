<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        $app = $this->createApplication();
        if (! $app->runningUnitTests()) {
            dd('You are not running your test suite on testing environment');
        }

        parent::setUp();
    }
}
