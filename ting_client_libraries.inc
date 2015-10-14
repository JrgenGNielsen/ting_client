<?php
/**
 * @file load Ting client library. Define autoload function for classes
 * in the library
 */


$path = libraries_get_path('WebserviceClient');

// Do the autoload.
spl_autoload_register('ting_client_autoload');
function ting_client_autoload($class_name) {
  $path = libraries_get_path('WebserviceClient');
  $dirs = array(
    $path .'/lib/',
    $path .'/lib/cache/',
    $path .'/lib/request/',
    $path .'/lib/exception/',
    $path .'/lib/adapter/',
    $path .'/lib/log/',
    $path .'/lib/result/',
    $path .'/lib/soapClient/',
    $path .'/lib/xsdparse/',
    $path .'/lib/common/'
  );

  foreach ($dirs as $dir) {
    if (file_exists($dir . $class_name . '.php')) {
      require_once($dir . $class_name . '.php');
      return;
    }
    elseif(file_exists($dir . $class_name . '.inc')) {
      require_once($dir . $class_name . '.inc');
      return;
    }
  }
}

// Include base object
if (!empty($path)) {
  require_once $path . '/TingClientBaseClass.php';
}