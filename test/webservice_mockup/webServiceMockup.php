<?php

/**
 * @file
 *
 * A mockup request to be used wiht ting_client
 *
 * Class webServiceMockup
 */
class webServiceMockup extends TingClientRequest{
  private $cacheEnable = TRUE;
  private $cacheTimeout = 0;

  public function setCacheEnable($value){
    $this->cacheEnable = $value;
  }

  public function setCacheTimeout($value){
    $this->cacheTimeout = $value;
  }

  public function processResponse(stdClass $response) {
    return $response;
  }

  public function cacheEnable($value = NULL) {
    return $this->cacheEnable;
  }

  public function cacheTimeout($value = NULL) {
    return $this->cacheTimeout;
  }

}