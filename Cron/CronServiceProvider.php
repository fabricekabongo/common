<?php

namespace FabriceKabongo\Common\Cron;

use Silex\ServiceProviderInterface;
use Silex\ControllerProviderInterface;
use Silex\Application;

/**
 * Description of navigationServiceProvider
 *
 * @author dell
 */
class CronServiceProvider implements ServiceProviderInterface, ControllerProviderInterface {

    /**
     * Registers services on the given app.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Application $app An Application instance
     */
    public function register(Application $app) {
        $app['fabricekabongo.common.cron.controller'] = $app->share(function ($app) {
                    return new CronController();
                });
    }

    /**
     * Bootstraps the application.
     *
     * This method is called after all services are registers
     * and should be used for "dynamic" configuration (whenever
     * a service must be requested).
     */
    public function boot(Application $app) {
        
    }

    public function connect(Application $app) {
//        if (!$app['resolver'] instanceof ServiceControllerResolver) {
//             using RuntimeException crashes PHP?!
//            throw new \LogicException('You must enable the ServiceController service provider to be able to use these routes.');
//        }

        /** @var ControllerCollection $controllers */
        $controllers = $app['controllers_factory'];

        $controllers->get('/emailcron', 'fabricekabongo.common.cron.controller:emailCronAction')
                ->bind('fabricekabongo.common.cron.emailcron');

        return $controllers;
    }

}

?>
