<?php

/**
 * Curfle - A lightweight, yet powerful PHP framework.
 *
 * @package  Curfle
 * @author   Julius Türich <info@joonlabs.com>
 */

$uri = urldecode(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH));

/**
 * This file allows us to emulate an Apache web server and its
 * .htaccess-mod_rewrite functionality with the built-in PHP
 * web server
 */
if ($uri !== "/" && file_exists(__DIR__ . "/public" . $uri))
    return false;

require_once __DIR__ . "/public/index.php";