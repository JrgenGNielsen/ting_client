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
 * $client = new ting_client_class()
 * $response = $client->do_request('forsrights', $params)
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
   * @throws \TingClientException
   */
  public function do_request($name, $params, $cache_me = TRUE) {
    if ($webservices = $this->getWebservices()) {
      $this->getRequestFactory()->addToUrls($webservices);
    }

    $request = $this->getRequestFactory()->getNamedRequest($name, $params);
    $response = $this->execute($request);

    return $response;
  }

  /**
   * Get webservices defined in HOOK_ting_client_webservice.
   *
   * @return array|FALSE
   */
  private function getWebservices() {
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
