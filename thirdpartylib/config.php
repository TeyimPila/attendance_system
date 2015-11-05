<?php
require "class.logsys.php";
\Fr\LS::config(array(
    /**
     * Basic Config of logSys
     */
    "basic" => array(
      "company" => "American University of Nigeria",
      "email" => "teyim.pila@aun.edu.ng",
      "email_callback" => 0
    ),
    
    /**
     * Database Configuration
     */
    "db" => array(
      "host" => "localhost",
      "port" => 3306,
      "username" => "root",
      "password" => "",
      "name" => "attendance",
      "table" => "instructor",
      "token_table" => "resetTokens"
    ),
    
    /**
     * Keys used for encryption
     * DONT MAKE THIS PUBLIC
     */
    "keys" => array(
      /**
       * Changing cookie key will expire all current active login sessions
       */
      "cookie" => "ckxc436jd*^30f840v*9!@#$",
      /**
       * `salt` should not be changed after users are created
       */
      "salt" => "^#$4%9f+1^p9)M@4M)V$"
    ),
    
    /**
     * Enable/Disable certain features
     */
    "features" => array(
      /**
       * Should I Call session_start();
       */
      "start_session" => true,
      /**
       * Enable/Disable Login using Username & E-Mail
       */
      "email_login" => true,
      /**
       * Enable/Disable `Remember Me` feature
       */
      "remember_me" => true,
      /**
       * Should \Fr\LS::init() be called automatically
       */
      "auto_init" => false,
      
      /**
       * Prevent Brute Forcing
       * ---------------------
       * By enabling this, logSys will deny login for the time mentioned 
       * in the "brute_force"->"time_limit" seconds after "brute_force"->"tries"
       * number of incorrect login tries.
       */
      "block_brute_force" => false,
      
      /**
       * Two Step Login
       * --------------
       * By enabling this, a checking is done when user visits
       * whether the device he/she uses is approved by the user.
       * Allows the original user to revoke logins in other devices/places
       * Useful if the user forgot to logout in some place.
       */
      "two_step_login" => false
    ),
    
    /**
     * `Blocking Brute Force Attacks` options
     */
    "brute_force" => array(
      /**
       * No of tries alloted to each user
       */
      "tries" => 5,
      /**
       * The time IN SECONDS for which block from login action should be done after
       * incorrect login attempts. Use http://www.easysurf.cc/utime.htm#m60s
       * for converting minutes to seconds. Default : 5 minutes
       */
      "time_limit" => 300
    ),
    
    /**
     * Information about pages
     */
    "pages" => array(
      /**
       * Pages that doesn't require logging in.
       * Exclude login page, but include REGISTER page.
       * Use Relative links or $_SERVER['REQUEST_URI']
       */
      "no_login" => array(
        
      ),
      /**
       * The login page. ex : /login.php or /accounts/login.php
       */
      "login_page" => "login.php",
      /**
       * The home page. The main page for logged in users.
       * logSys redirects to here after user logs in
       */
      "home_page" => "home.php",
    ),
    
    /**
     * Settings about cookie creation
     */
    "cookies" => array(
      /**
       * Default : cookies expire in 30 days. The value is
       * for setting in strtotime() function
       * http://php.net/manual/en/function.strtotime.php
       */
      "expire" => "+30 days",
      "path" => "/",
      "domain" => "local.dev",
    ),
    
    /**
     * 2 Step Login
     */
    'two_step_login' => array(
      /**
       * Message to show before displaying "Enter Token" form.
       */
      'instruction' => '',
      
      /**
       * Callback when token is generated.
       * Used to send message to user (Phone/E-Mail)
       */
      'send_callback' => '',
      
      /**
       * The table to stoe user's sessions
       */
      'devices_table' => 'user_devices',
      
      /**
       * The length of token generated.
       * A low value is better for tokens sent via Mobile SMS
       */
      'token_length' => 4,
      
      /**
       * Whether the token should be numeric only ?
       * Default Token : Alphabetic + Numeric mixed strings
       */
      'numeric' => false,
      
      /**
       * The expire time of cookie that authorizes the device
       * to login using the user's account with 2 Step Verification
       * The value is for setting in strtotime() function
       * http://php.net/manual/en/function.strtotime.php
       */
      'expire' => '+45 days',
      
      /**
       * Should logSys checks if device is valid, everytime
       * logSys is initiated ie everytime a page loads
       * If you want to check only the first time a user loads
       * a page, then set the value to TRUE, else FALSE
       */
      'first_check_only' => true
    )
 ));