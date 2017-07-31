<?php
/**
 * Drupal supoort module for the TingClient library.
 * @see libraries/TingClient
 */

/**
 * Usage.
 * 1. Implement hook_ting_client_webservice (@see below).
 * 2. Implement a request by extending  TingClientRequest (@see example request below).
 * 3. Execute the request: ting_client_do_request($name, $params);
 *
 * example
 * $params = array(
 * 'action' => 'getAnimals',
 * 'species' => array('birds', 'toads')
 * );
 *
 * $response = ting_client_do_request('mywebservice', $params);
 *
 */


/**
 * HOOK to define a webservice.
 *
 * Define the settings used for commnunicating with a webservice via the TingClient.
 *
 * Definition must be of the form
 *  name => $settings
 * where $settings is an array with the following components
 *
 * Required:
 *  'class' ; the class handling parameters for the webservice. It MUST be extended
 *            from TingClientRequest.
 *            @see exampleclass below
 *  'url' : Url of the webservice.
 *
 * Optional:
 *  'xsd_url' : If set ting_client will attempt to download the xsd and parse parameters
 *              according to definitions in schema.
 *  'xsdNameSpace : One or more namespaces to prepend to parameters in request
 *
 */
function hook_ting_client_webservices(){
  return array(
    'mywebservice' => array(
      'class' => 'myRequestClass',
      'url' => 'http://mywebserviceurl.com',
      'xsd_url' => 'http://mywebserviceurl.com/xsd',
      'xsdNameSpace' => array(0=>'http://mywebserviceurl.com/ns/mywebservice'),
    ),
  );
}

/**
 * An example request class.
 * @see libraries/TingClient/request/TingClientRequest.php
 */

class myrRequestClass extends TingClientRequest{
  public function processResponse(stdClass $response) {
    // do preprocessing here
    return $response;
  }

  /**
   * whether to enable cache for this request or not
   * @return bool
   */
  public function cacheEnable() {
    return TRUE;
  }

  /**
   * Where to cache.
   * @return string
   */
  public function cacheBin() {
    return 'cache_webservices';
  }

  /**
   * Cache timeout
   * @return int
   */
  public function cacheTimeout() {
    // cache for 10 minutes
    return 10;
  }

  /**
   * TingClient supports php soapclient, embedded NanoClient and MicroCURL.
   * @return string SOAPCLIENT|NANOCLIENT|REST
   *
   * Defaults to NANOCLIENT
  **/
  public function getClientType() {
    return 'SOAPCLIENT';
  }
}