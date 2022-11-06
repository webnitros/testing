<?php

namespace AppTesting\Foundation;

use Illuminate\Container\Container;
use Illuminate\Contracts\Console\Kernel;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

trait CreatesApplication
{
    public function createApplication()
    {
        $container = Container::getInstance();


        $container->bind(HttpKernel::class, function (Container $container) {

            // регистрация событи
            $dispatcher = new EventDispatcher();

            // регистраиця роутеров
            $routes = $this->router();

            // какие то проблемы с роутерами решает
            $matcher = new UrlMatcher($routes, new RequestContext());
            $dispatcher = new EventDispatcher();

            // add event Routers
            $dispatcher->addSubscriber(new RouterListener($matcher, new RequestStack()));

            $controllerResolver = new ControllerResolver();

            $argumentResolver = new ArgumentResolver();

            return new HttpKernel($dispatcher, $controllerResolver, new RequestStack(), $argumentResolver);
        });


        // Регистрируем класс

        #$HttpKernel =  $this->app->make(HttpKernel::class);
        # $HttpKernel->register('dave@davejamesmiller.com', 'MySuperSecurePassword!');


        #$this->app->bind(Kernel::class);
        #$this->app->singleton(Kernel::class,Kernel::class);
        #$this->app->make(Kernel::class);

        return $container;
    }

    public function router()
    {
        return include dirname(__FILE__, 2) . '/config/routers.php';
    }
}
