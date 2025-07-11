<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->post('auth/login', 'Auth::login');
$routes->get('profile', 'User::profile', ['filter' => 'jwt']);
$routes->resource('produk', ['filter' => 'jwt']);
