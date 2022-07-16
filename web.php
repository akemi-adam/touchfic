<?php

use Capangas\Touchfic\app\Router;

$router = new Router();

/**
 * Rotas básicas
 */

$router->get('/', '/views/index.php');
$router->get('/about', '/views/about.php');
$router->get('/faq', '/views/faq.php');

/**
 * Rotas auth
 */

$router->get('/login', '/views/auth/login.php');
$router->post('/login', '/views/auth/login.php');
$router->get('/register', '/views/auth/register.php');
$router->post('/register', '/views/auth/register.php');
$router->get('/dashboard', '/views/dashboard.php', true);
$router->post('/logout', '/views/auth/logout.php', true);

/**
 * Rotas de postagens
 */

$router->get('/posts/register', '/views/posts/register.php', true);
$router->post('/posts/register', '/views/posts/register.php', true);
$router->get('/posts/show', '/views/posts/show.php', true);
$router->post('/posts/show', '/views/posts/show.php', true);

/**
 * Rotas de admin
 */
$router->get('/admin/genders/register', '/views/admin/gender/register.php', true);
$router->post('/admin/genders/register', '/views/admin/gender/register.php', true);
$router->get('/admin/genders/show', '/views/admin/gender/show.php', true);
$router->post('/admin/genders/show', '/views/admin/gender/show.php', true);
$router->get('/admin', '/views/admin/dashboard.php', true);

/**
 * Rotas de histórias
 */

$router->get('/storie/create', '/views/stories/create.php', true);
$router->post('/storie/create', '/views/stories/create.php', true);
$router->get('/storie/show', '/views/stories/show.php', true);
$router->post('/storie/show', '/views/stories/show.php', true);
$router->get('/storie/mystories', '/views/stories/mystories.php', true);
$router->post('/storie/mystories', '/views/stories/mystories.php', true);
$router->get('/storie/profile', '/views/stories/profile.php', true);
$router->post('/storie/profile', '/views/stories/profile.php', true);
$router->get('/storie/chapter/create', '/views/stories/chapter/create.php', true);
$router->post('/storie/chapter/create', '/views/stories/chapter/create.php', true);
$router->get('/storie/chapter/show', '/views/stories/chapter/show.php', true);
$router->post('/storie/chapter/show', '/views/stories/chapter/show.php', true);
$router->post('/storie/chapter/show-aux', '/views/stories/chapter/show_aux.php', true);

return $router;