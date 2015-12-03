<?php

/**
 * @file
 * Class ting_client_class
 *
 * Drupal integration with TingClient library.
 *
 * Sample usage:
 *
 * $params = array(
 * 'action' => 'forsRightsRequest',
 * 'userIdAut' => '*****',
 * 'groupIdAut' => '*****',
 * 'passwordAut' => '******',
 * 'outputType' => 'json',
 * );
 *
 * $response = ting_client_do_request('forsrights', $params)
 *
 * Sorry for the name - it is for easier integration with bibliotek.dk.
 * It will be refactored later on.
 */
class ting_client_class extends TingClient {

  /**
   * Execute a request.
   *
   * @param string    $name
   *  name of the request
   * @param  array    $params
   *  parameters for the request
   * @param bool|TRUE $cache_me
   *  Whether to overwrite cache settings
   *
   * @return string
   * @throws TingClientException
   */
  public function do_request($name, $params, $cache_me = TRUE) {
    // @TODO start timer

    if ($webservices = $this->getWebservices()) {
      $this->getRequestFactory()->addToUrls($webservices);
    }
    
    // Check if the url has been set yet.
    if ($webservices[$name]['class'] . '_url' == $webservices[$name]['url']) {
      return FALSE;
    }

    try {
      /** @var TingClientRequest $request */
      $request = $this->getRequestFactory()->getNamedRequest($name, $params);
    } catch (TingClientException $e) {
      drupal_set_message($e->getMessage(), 'ting client', 'error');
      return FALSE;
    }

    // Only use drupal cacher if caching is set
    // @see admin/config/serviceclient/settings
    // Otherwise use default cacher in TingClient library
    // @see libraries/TingCLient/cache/TingClientCacher.php

    // Check overall caching.
    if (variable_get('webservice_client_enable_cache', TRUE)) {
      // check caching for individual request
      if (ting_client_class::cacheEnable($request) !== FALSE) {
        $cacher = new TingClientDrupalCacher($request);
        $this->setCacher($cacher);
      }
    }

    // Always use drupal logger.
    $logger = new TingClientDrupalLogger();
    $this->setLogger($logger);
    try {
      // execute request
      $response = $this->execute($request);
      // @ TODO stop timer
      $result = $request->parseResponse($response);
    } catch (Exception $e) {
      // Do nothing.
      $result = FALSE;
    }
    return $result;
  }

  /**
   * Should given request be cached ?
   *
   * @param TingClientRequest $request
   *
   * @return string|bool
   */
  public static function cacheEnable(TingClientRequest $request) {
    $class_name = get_class($request);
    return variable_get($class_name . TingClientRequest::CACHEENABLE, FALSE);
  }

  /**
   * Get timeout for given request.
   *
   * @param \TingClientRequest $request
   *
   * @return string|bool
   */
  public static function cacheTimeOut(TingClientRequest $request) {
    $class_name = get_class($request);
    return variable_get($class_name . TingClientRequest::CACHELIFETIME, 1);
  }

  /**
   * Get webservices defined in HOOK_ting_client_webservice().
   *
   * @return array|FALSE
   */
  public function getWebservices() {
    // check if services has already been set.
    $webservices = variable_get('ting_client_webservice_definitions', FALSE);
    if ($webservices === FALSE) {
      $webservices = module_invoke_all('ting_client_webservice');
      $this->placeholdersToVariable($webservices);
      // set services variable
      variable_set('ting_client_webservice_definitions', $webservices);
    }

    return $webservices;
  }

  /**
   * Replace placeholders in webservices with corresponding variable.
   *
   * @param array $webservices
   */
  private function placeholdersToVariable(&$webservices) {
    foreach ($webservices as $name => &$settings) {
      foreach ($settings as $key => $placeholder) {
        // some placeholders are arrays -skip
        if (is_array($placeholder)) {
          continue;
        }
        if ($real_value = variable_get($placeholder)) {
          $settings[$key] = $real_value;
        }
      }
    }
  }
}
