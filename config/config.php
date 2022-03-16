<?php
//The main config file
define('BASE_URL', 'http://localhost:8080/platinummine/');
define('ENV', 'dev');
define('DEFAULT_MODULE', 'welcome');
define('DEFAULT_CONTROLLER', 'Welcome');
define('DEFAULT_METHOD', 'index');
define('APPPATH', dirname(dirname(__FILE__)).'/');
define('REQUEST_TYPE', $_SERVER['REQUEST_METHOD']);
define('MODULE_ASSETS_TRIGGER', '_module');

// shopping cart settings
define('CURRENCY_CODE', 'USD');
define('CURRENCY_SYMBOL', '$');
define('CURRENCY_CODEGBP', 'GBP'); // 'EUR'
define('CURRENCY_SYMBOLGBP', '&pound;'); // '&euro;'
define('PAYPAL_EMAIL_ADDRESS', 'mbrick02@yahoo.com');