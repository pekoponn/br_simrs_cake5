<?php
/**
 * Routes configuration.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * It's loaded within the context of `Application::routes()` method which
 * receives a `RouteBuilder` instance `$routes` as method argument.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
/*
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass()`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 */
return static function (RouteBuilder $routes): void {
$routes->setRouteClass(DashedRoute::class);

// Prefix otomatis dari folder src/Controller/<Modul>; URL tetap tanpa nama modul
$skipFolders = ['Component', 'Acc', 'Hr'];
foreach (glob(APP . 'Controller' . DS . '*', GLOB_ONLYDIR) as $dir) {
    $prefix = basename($dir);
    if (in_array($prefix, $skipFolders, true)) {
        continue;
    }
    $controllers = array_map(
        fn($f) => basename($f, 'Controller.php'),
        glob($dir . DS . '*Controller.php')
    );
    if (!$controllers) {
        continue;
    }
    $routes->prefix($prefix, ['path' => '/'], function (RouteBuilder $b) use ($controllers) {
        foreach ($controllers as $c) {
            $path = '/' . \Cake\Utility\Inflector::dasherize($c);
            $b->connect($path, ['controller' => $c, 'action' => 'index']);
            $b->connect($path . '/{action}/*', ['controller' => $c]);
        }
    });
}

$routes->scope('/', function (RouteBuilder $builder) {
    $builder->connect('/telegram/webhook', ['controller' => 'Telegram', 'action' => 'webhook'], ['_method' => 'POST']);
    /*
     * Here, we are connecting '/' (base path) to a controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use (in this case, templates/Pages/home.php)...
     */
    //$builder->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);

    // Diseting seperti ini karena Users tidak semua user mendapat akses 'Users'
    //$builder->connect('/', ['controller' => 'Home', 'action' => 'index', 'login']);
    $builder->connect('/', ['controller' => 'Dashboard', 'action' => 'index', 'login']);

    /*
     * ...and connect the rest of 'Pages' controller's URLs.
     */
    $builder->connect('/pages/*', 'Pages::display');
    $builder->connect(
        '/medical-records/history/:patient_id',
        ['controller' => 'MedicalRecords', 'action' => 'history'],
        ['pass' => ['patient_id'], 'patient_id' => '\d+']
    );
    $builder->connect(
        '/polyclinic-queues/search-poly',
        ['prefix' => 'Registrasi', 'controller' => 'PolyclinicQueues', 'action' => 'searchPoly'],
        ['_method' => 'GET']
    );
    $builder->connect(
        '/polyclinic-queues/search-poly-queue',
        ['prefix' => 'Registrasi', 'controller' => 'PolyclinicQueues', 'action' => 'searchPolyQueue'],
        ['_method' => 'GET']
    );
    $builder->connect(
        '/polyclinic-queues/create-referral-queue',
        ['prefix' => 'Registrasi', 'controller' => 'PolyclinicQueues', 'action' => 'createReferralQueue'],
        ['_method' => 'POST']
    );
    $builder->connect(
        '/outpatient-visit-emr/save-anatomy/:visit_id',
        ['controller' => 'OutpatientVisitEmr', 'action' => 'saveAnatomy'],
        ['_method' => 'POST', 'pass' => ['visit_id'], 'visit_id' => '\d+']
    );

    /*
     * Connect catchall routes for all controllers.
     *
     * The `fallbacks` method is a shortcut for
     *
     * ```
     * $builder->connect('/:controller', ['action' => 'index']);
     * $builder->connect('/:controller/:action/*', []);
     * ```
     *
     * You can remove these routes once you've connected the
     * routes you want in your application.
     */
    $builder->fallbacks();
});

//prefix Accounting 
$routes->prefix('acc', function (RouteBuilder $routes) {
    $routes->connect('/', ['controller' => 'Acc', 'action' => 'index']);
    $routes->fallbacks(DashedRoute::class);
});

// prefix HR
$routes->prefix('hr', function (RouteBuilder $routes) {
    $routes->connect('/', ['controller' => 'Hr', 'action' => 'index']);
    $routes->fallbacks(DashedRoute::class);
});

// // prefix HSE 
// Router::prefix('hse', function (RouteBuilder $routes) {
//     $routes->connect('/', ['controller' => 'Hse', 'action' => 'index']);
//     $routes->fallbacks(DashedRoute::class);
// });

// // prefix Marketing 
// Router::prefix('mkt', function (RouteBuilder $routes) {
//     $routes->connect('/', ['controller' => 'Mkt', 'action' => 'index']);
//     $routes->fallbacks(DashedRoute::class);
// });

// // prefix Production 
// Router::prefix('pro', function (RouteBuilder $routes) {
//     $routes->connect('/', ['controller' => 'Pro', 'action' => 'index']);
//     $routes->fallbacks(DashedRoute::class);
// });

// // prefix Transport 
// Router::prefix('trs', function (RouteBuilder $routes) {
//     $routes->connect('/', ['controller' => 'Trs', 'action' => 'index']);
//     $routes->fallbacks(DashedRoute::class);
// });

// // prefix Warehouse 
// Router::prefix('whs', function (RouteBuilder $routes) {
//     $routes->connect('/', ['controller' => 'Whs', 'action' => 'index']);
//     $routes->fallbacks(DashedRoute::class);
// });

// prefix Master 
$routes->prefix('master', function (RouteBuilder $routes) {
    $routes->connect('/', ['controller' => 'Master', 'action' => 'index']);
    $routes->fallbacks(DashedRoute::class);
});

// // prefix IT 
// Router::prefix('it', function (RouteBuilder $routes) {
//     $routes->connect('/', ['controller' => 'It', 'action' => 'index']);
//     $routes->fallbacks(DashedRoute::class);
// });*/

/*
 * If you need a different set of middleware or none at all,
 * open new scope and define routes there.
 *
 * ```
 * $routes->scope('/api', function (RouteBuilder $builder) {
 *     // No $builder->applyMiddleware() here.
 *     
 *     // Parse specified extensions from URLs
 *     // $builder->setExtensions(['json', 'xml']);
 *     
 *     // Connect API actions here.
 * });
 * ```
 */
};