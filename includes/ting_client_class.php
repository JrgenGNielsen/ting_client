<?php

/**
 * @file
 * Class ting_client_class
 *
 * Sorry for the name - it is for easier integration with bibliotek.dk.
 * It will be refactored later on.
 */
class ting_client_class extends TingClient {

  public function do_request($name, $params, $cache_me = TRUE) {
    $request = $this->getRequestFactory()->getNamedRequest($name, $params);
    $response = $this->execute($request);

    return $response;
  }
}
