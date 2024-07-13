
<?php

session_start();
require_once 'database/DataBase.php';
require_once 'activities/Admin/Admin.php';
require_once 'activities/Admin/Category.php';
require_once 'activities/Admin/Post.php';

define('BASE_PATH', __DIR__);  // project folder complete address
define('CURRENT_DOMAIN', currentDomain().'/php_basic/04-ex/');    // full domein of current file
define('DISPLAY_ERROR' , true);   // whether display errors to user or not - if true , show errors
define('DB_HOST' , 'localhost');
define('DB_NAME' , 'news_2');
define('DB_USERNAME' , 'root');
define('DB_PASSWORD' , '123');

// helpers
function protocol()   //   http:// or https://
{
    return stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true ? 'https://' : 'http://';
}

function currentDomain()   //   http://localhost
{
    return protocol() . $_SERVER['HTTP_HOST'];
}

function asset($src)    //   path to assets . in public folder
{
    $domain = trim(CURRENT_DOMAIN, '/ ');
    $src = $domain . '/public' . '/' . trim($src, '/ ');
    return $src;
}

function url($url)   // return complete file url
{
    $domain = trim(CURRENT_DOMAIN, '/ ');
    $url = $domain . '/' . trim($url, '/ ');
    return $url;
}

function currentUrl()   // complete url+uri request
{
    return currentDomain() . $_SERVER['REQUEST_URI'];
}

function methodField() // get or post
{
    return $_SERVER['REQUEST_METHOD'];
}

// function to show errors or not
function displayErrors($displayErrors)
{
    if ($displayErrors) {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    } else {
        ini_set('display_errors', 0);
        ini_set('display_startup_errors', 0);
        error_reporting(0);
    }
}

displayErrors(DISPLAY_ERROR);

global $flashMessage;
if (isset($_SESSION['flash_message'])) {
    $flashMessage = $_SESSION['flash_message'];
    unset($_SESSION['flash_message']);
}

function flash($name, $value = null)
{
    if (is_null($value)) {
        global $flashMessage;
        $message = isset($flashMessage[$name]) ? $flashMessage[$name] : '';
        return $message;
    } else {
        $_SESSION['flash_message'] = $value;
    }
}

function uri($reservedUrl, $class, $method, $requestMethod = 'GET')
{
    // current url
    $currentUrl = explode('?', currentUrl())[0];
    $currentUrl = str_replace(CURRENT_DOMAIN, '', $currentUrl);
    $currentUrl = trim($currentUrl, '/');
    $currentUrlArray = explode('/', $currentUrl);
    $currentUrlArray = array_filter($currentUrlArray);

    // reserved url
    $reservedUrl = trim($reservedUrl, '/');
    $reservedUrlArray = explode('/', $reservedUrl);
    $reservedUrlArray = array_filter($reservedUrlArray);

    if (sizeof($reservedUrlArray) != sizeof($currentUrlArray) || methodField() != $requestMethod) {
        return false;
    }

    $parameters = [];
    for ($key = 0; $key < sizeof($currentUrlArray); $key++) {
        if ($reservedUrlArray[$key][0] == '{' && $reservedUrlArray[$key][sizeof($reservedUrlArray) - 1] == '}') {
            array_push($parameters, $currentUrlArray[$key]);
        } elseif ($reservedUrlArray[$key] != $currentUrlArray[$key]) {
            return false;
        }
    }

    if (methodField() == 'POST') {
        $request = isset($_FILES) ? array_merge($_FILES, $_POST) : $_POST;
        $parameters = array_merge([$request], $parameters);
    }

    $object = new $class;
    call_user_func_array([$object, $method], $parameters);
    exit;
}
function dd($var)
{
    echo '<pre>';
    var_dump($var);
    exit;
}

// admin --------------------------------------------------
uri('admin','Admin\Admin','index');



// category
uri('admin/category', 'Admin\Category', 'index');
uri('admin/category/create', 'Admin\Category', 'create');
uri('admin/category/store', 'Admin\Category', 'store', 'POST');
uri('admin/category/edit/{id}', 'Admin\Category', 'edit');
uri('admin/category/update/{id}', 'Admin\Category', 'update', 'POST');
uri('admin/category/delete/{id}', 'Admin\Category', 'delete');

// // post
uri('admin/post', 'Admin\Post', 'index');
uri('admin/post/create', 'Admin\Post', 'create');
uri('admin/post/store', 'Admin\Post', 'store', 'POST');
uri('admin/post/edit/{id}', 'Admin\Post', 'edit');
uri('admin/post/update/{id}', 'Admin\Post', 'update', 'POST');
uri('admin/post/delete/{id}', 'Admin\Post', 'delete');

// // auth ----------------------------------------------------
// // app -----------------------------------------------------

echo '404 - Not found';

