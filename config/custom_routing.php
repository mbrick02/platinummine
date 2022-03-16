<?php
$routes = [
    'tg-admin/logout' => 'trongate_administrators/logout',
    'tg-admin' => 'trongate_administrators/manage',
    'thankyou' => 'paypal/thankyou',
    'cancel' => 'paypal/cancel'
];
define('CUSTOM_ROUTES', $routes);