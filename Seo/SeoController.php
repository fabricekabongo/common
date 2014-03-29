<?php

namespace FabriceKabongo\Common\Cron;

use Symfony\Component\HttpFoundation\Request;
use Silex\Application;

/**
 * do cron actions
 *
 * @author fabrice kabongo <fabrice.k.kabongo@gmail.com>
 */
class CronController {

    public function emailCronAction(Application $app, Request $request) {
        $transport = $app["swiftmailer.transport"];

        if ($transport instanceof \Swift_Transport_SpoolTransport) {
            $spool = $transport->getSpool();
            $spool->setMessageLimit(30);
            $spool->setTimeLimit(200);
            $sent = $spool->flushQueue($app["swiftmailer.transport.original"]);
        }
        return "$sent sent";
    }

}

?>
