<?php
/**
 * AstraClicks - Logout
 */
require_once __DIR__ . '/app/config/database.php';
require_once __DIR__ . '/app/helpers/functions.php';

$_SESSION = [];
session_destroy();
redirect(BASE_URL . '/user-admin.php');
