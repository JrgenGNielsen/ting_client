<?php
/**
 * @file load Ting client library. Define autoload function for classes
 * in the library
 */


$path = libraries_get_path('TingClient');

// Include base object
if (!empty($path)) {
  require_once $path . '/lib/TingClient.php';
}
else{
  throw new TingClientMissingLibraryException('Missing TingCLient library');
}