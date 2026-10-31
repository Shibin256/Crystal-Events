<?php
/**
 * Crystal Events - Central Configuration File
 */

// Database Configuration
if (!defined('DB_HOST')) define('DB_HOST', 'localhost');
if (!defined('DB_USER')) define('DB_USER', 'root');
if (!defined('DB_PASS')) define('DB_PASS', '');
if (!defined('DB_NAME')) define('DB_NAME', 'crystal-events');
if (!defined('DB_PORT')) define('DB_PORT', 3306);

// Application Configuration
if (!defined('BASE_URL')) define('BASE_URL', 'http://localhost:8080/Crystal-Events/');
if (!defined('TIMEZONE')) define('TIMEZONE', 'Asia/Kolkata');

// Payment Gateway Configuration
// Set MOCK_PAYMENTS to true for local testing without real Razorpay transactions.
// Set to false to verify real Razorpay payment signatures server-side.
if (!defined('MOCK_PAYMENTS')) define('MOCK_PAYMENTS', true);
if (!defined('RAZORPAY_KEY_ID')) define('RAZORPAY_KEY_ID', 'rzp_test_rWSgaJR2BxzRC3');
if (!defined('RAZORPAY_KEY_SECRET')) define('RAZORPAY_KEY_SECRET', 'YOUR_KEY_SECRET_HERE');
