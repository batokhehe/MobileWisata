<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('/location_post/(:num)', 'Home::location_post/$1');
$routes->get('/blog_post/(:num)', 'Home::blog_post/$1');
$routes->get('/location', 'Home::location');
$routes->get('/blog_list', 'Home::blog_list');

$routes->group('api', function ($routes) {
    $routes->post('register', 'User::register');
    $routes->post('login', 'User::login');
    $routes->get('profile', 'User::details');
    $routes->post('change-profile', 'User::change_profile');
    $routes->post('change-password', 'User::change_password');
    $routes->post('forgot-password', 'User::forgot_password');
    $routes->resource('user');
    $routes->resource('category');
    $routes->resource('favorite');
    $routes->resource('rateReview');
    $routes->get('media', 'Media::index');
    $routes->post('media', 'Media::create');
    $routes->post('media/(:num)', 'Media::update/$1');
    $routes->get('media/(:num)', 'Media::show/$1');
    $routes->delete('media/(:num)', 'Media::delete/$1');
    $routes->get('destination', 'Destination::index');
    $routes->post('destination', 'Destination::create');
    $routes->post('destination/(:num)', 'Destination::update/$1');
    $routes->get('destination/(:num)', 'Destination::show/$1');
    $routes->delete('destination/(:num)', 'Destination::delete/$1');

    $routes->get('headline/(:num)', 'Headline::show/$1');
    $routes->post('headline/(:num)', 'Headline::update/$1');
});

$routes->group('admin', function ($routes) {
    $routes->get('auth', 'Auth::index');
    $routes->get('auth/login', 'Auth::login' , ['as' => 'login_admin_page']);
    $routes->post('auth/login', 'Auth::login');
    $routes->get('auth/logout', 'Auth::logout');

    $routes->get('/', 'DestinationAdmin::index');
    $routes->get('destination', 'DestinationAdmin::index');
    $routes->get('destination/create', 'DestinationAdmin::create');
    $routes->get('destination/edit/(:num)', 'DestinationAdmin::edit/$1');


    $routes->get('headline', 'HeadlineAdmin::index');

    $routes->get('media/create/(:num)', 'MediaAdmin::create/$1');

    $routes->get('category', 'CategoryAdmin::index');
    $routes->get('category/create', 'CategoryAdmin::create');
    $routes->get('category/edit/(:num)', 'CategoryAdmin::edit/$1');
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
