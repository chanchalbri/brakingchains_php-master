<?php error_reporting(0);
// constants.php - called by various pages of the application
// to access defined constant variables
//
// (c) 2020, Breaking Chains
// Written by James Misa

// Database Constants
define("DB_SERVER", "us-cdbr-east-02.cleardb.com");
define("DB_USER", "ba72fc784f4043");
define("DB_PASS", "c502dce1");
define("DB_NAME", "heroku_7c9eb8ff815e206");

define("DB_SERVER_L", "127.0.0.1:3306");
define("DB_USER_L", "root");
define("DB_PASS_L", "");
define("DB_NAME_L", "breakingchains");

define("AMB_USERID", "/users/u-7bcje2s422dq2ujbsqecqka");
define("AMB_USERNAME", "t-dnyfvtpzmsqddiv5movfbsq");
define("AMB_PASSWORD", "tnkrhnt5g5i5neegfyeqc4u7k5c3kl5qjnq7huq");
define("AMB_HOST", "https://api.catapult.inetwork.com/v1");

define("AMB_PHONE", "+12092134208");

define ('ROOT_PATH', realpath(dirname(__FILE__)));

define("CLEARDB_LOGIN", "heroku config:set DATABASE_URL='mysql://b5689c8abd7dde:4651e49b@us-cdbr-iron-east-03.cleardb.net/heroku_58e2bb35b237675?reconnect=true'");

define("URL", "https://breakingchainsprivatecoop.com");
    
?>