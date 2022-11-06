<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 24.03.2021
 * Time: 22:49
 */

namespace Tests;

use AppTesting\Foundation\CreatesApplication;
use AppTesting\Foundation\InteractsWithAuthentication;
use AppTesting\Foundation\MakesHttpRequests;
use Mockery\Adapter\Phpunit\MockeryTestCase;

abstract class TestCase extends MockeryTestCase
{
    use CreatesApplication;
    use MakesHttpRequests;
    use InteractsWithAuthentication;

    /**
     * The Illuminate application instance.
     *
     * @var \Illuminate\Container\Container
     */
    protected $app;

    protected function setUp(): void
    {
        $this->app = $this->createApplication();
        parent::setUp();
    }

    public function router()
    {
        $routes = new \AppTesting\Helpers\Route();
        $routes->prefixStack('/api')->group([], function (\AppTesting\Helpers\Route $r) {
            $r->post('/login', [\AppTesting\Http\Controllers\Auth\LoginController::class, 'login']);
            $r->post('/logout', [\AppTesting\Http\Controllers\Auth\LoginController::class, 'logout']);
            $r->post('/user', [\AppTesting\Http\Controllers\Auth\LoginController::class, 'current']);
        });

        return $routes;
    }
}
