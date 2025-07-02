<?php

/**
 * @author Puji Ermanto <pujiermanto@gmail.com> | AKA Maman Nur Furqon
 * @license MIT License
 * @link
 * @return void
 */

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('auth/google',          'Auth::google');
$routes->get('auth/google/callback', 'Auth::googleCallback');
$routes->post('auth/login', 'Auth::login');
$routes->get('auth/logout', 'Auth::logout');
$routes->get('kuesioner/alumni', 'KuesionerAlumni::index', ['filter' => 'auth']);
$routes->post('kuesioner/alumni/simpan', 'KuesionerAlumni::simpan');
$routes->get('kuesioner/pengguna', 'KuesionerPengguna::index');
$routes->post('kuesioner/pengguna/simpan', 'KuesionerPengguna::simpan');
$routes->get('laporan/alumni', 'Rekap::tracer');
$routes->get('laporan/pengguna', 'Rekap::pengguna');
$routes->get('rekap/export/alumni', 'Rekap::exportAlumni');
$routes->get('rekap/export/pengguna', 'Rekap::exportPengguna');

// Admin Routes
$routes->get('admin', 'Admin\Auth::login');
$routes->post('admin/login', 'Admin\Auth::doLogin');
$routes->get('admin/logout', 'Admin\Auth::logout');


$routes->group('admin', ['filter' => 'admin'], function ($routes) {
    $routes->get('dashboard', 'Admin\Dashboard::index');
    $routes->get('alumni', 'Admin\Alumni::index');
    $routes->get('pengguna', 'Admin\Pengguna::index');
    $routes->get('admin/alumni', 'Admin\Alumni::index');
    $routes->get('admin/pengguna', 'Admin\Pengguna::index');
    $routes->get('alumni/detail/(:num)', 'Admin\Alumni::detail/$1');
    $routes->get('admin/alumni/delete/(:num)', 'Admin\Alumni::delete/$1');
    $routes->get('admin/alumni/cetak', 'Admin\Alumni::cetak');
    $routes->get('admin/pengguna/cetak', 'Admin\Pengguna::cetak');
    $routes->get('admin/alumni/add', 'Admin\Alumni::add');
    $routes->post('admin/alumni/save', 'Admin\Alumni::save');
    $routes->get('alumni/edit/(:num)', 'Admin\Alumni::edit/$1');
    $routes->post('alumni/update/(:num)', 'Admin\Alumni::update/$1');
    $routes->get('periode', 'Admin\Periode::index');
    $routes->get('periode/tambah', 'Admin\Periode::tambah');
    $routes->post('periode/simpan', 'Admin\Periode::simpan');
    // ✅ Route untuk upload dokumen panduan
    $routes->get('panduan', 'Admin\Panduan::index');
    $routes->post('panduan/upload', 'Admin\Panduan::upload');
});

$routes->get('alumni/dashboard', 'Alumni\Dashboard::index', ['filter' => 'auth']);
