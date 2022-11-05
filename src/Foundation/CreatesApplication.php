<?php

namespace AppTesting\Foundation;

use Illuminate\Contracts\Console\Kernel;

trait CreatesApplication
{
    public function createApplication()
    {
        $app = require __DIR__ . '/../bootstrap/app.php';
        $app->make(Kernel::class)->bootstrap();
        $this->app = $app;
        return $app;
    }

    public function router()
    {
        return include dirname(__FILE__, 2) . '/config/routers.php';
    }
}
