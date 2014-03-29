<?php

namespace FabriceKabongo\Common\Seo;

use Silex\ServiceProviderInterface;
use Silex\ControllerProviderInterface;
use Silex\Application;

/**
 * Description of navigationServiceProvider
 *
 * @author dell
 */
class SeoServiceProvider implements ServiceProviderInterface, ControllerProviderInterface {

    /**
     * Registers services on the given app.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Application $app An Application instance
     */
    public function register(Application $app) {
        $app['fabricekabongoc.seomanager'] = $app->share(function ($app) {
                    return MetaManager::loadMeta($app['db'], $app['fabricekabongoc.']['seooptions.meta.table']);
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


        /** @var ControllerCollection $controllers */
        $controllers = $app['controllers_factory'];
        return $controllers;
    }

}

?>
