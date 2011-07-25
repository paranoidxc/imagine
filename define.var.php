<?php
// change the following paths if necessary
$website_dir = dirname(__FILE__);
$g_upfiles_dir = '/upfiles';
$atms_dave_dir = $website_dir.'/upfiles/';
$avts_dir = $website_dir.$g_upfiles_dir.'/avatars/';

define('SITE_TITLE','影像志');
define('WEBSITE_DIR',$website_dir);
define('ATMS_SAVE_DIR',$atms_dave_dir);
define('UPFILES_DIR', $g_upfiles_dir);
define('UPFILES_AVTS_DIR', $avts_dir);
define('THUMB_SIZE',  '160_120');
define('GAVATAR_SIZE','48_48');
define('LARGE_SIZE',  '800_500');
define('IHOST_STUDIO', 'http://www.google.com');

define("AVATAR_MAX_WIDTH", 600);
define("AVATAR_MAX_HEIGHT", 400);

define("VIVI_WIDTH", 120);
define("VIVI_HEIGHT", 160);

define("AVATAR_WIDTH", 80);
define("AVATAR_HEIGHT", 80);
define("AVATAR_PREFIX", 'source_');

define("SECRET", 'ihuangxc');

define("ADMIN_URL", "/cp/Dashboard/index");
