<?php

namespace Mastercity\Markdown\Provider;


use Mastercity\Markdown\Parser\Parser;
use Mastercity\Markdown\Twig\Extension;
use Silex\Application;
use Silex\ServiceProviderInterface;

class MarkdownProvider implements ServiceProviderInterface
{

    /**
     * Registers services on the given app.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     */
    public function register(Application $app)
    {
        $app['parsedown'] = $app->share(function () {
            $parsedown = new Parser();
            $parsedown->setBreaksEnabled(true);

            return $parsedown;
        });

        $app['twig'] = $app->share($app->extend('twig', function ($twig, $app) {
            $twig->addExtension(new Extension($app['parsedown']));
            return $twig;
        }));

    }

    /**
     * Bootstraps the application.
     *
     * This method is called after all services are registered
     * and should be used for "dynamic" configuration (whenever
     * a service must be requested).
     */
    public function boot(Application $app)
    {
        // TODO: Implement boot() method.
    }
}