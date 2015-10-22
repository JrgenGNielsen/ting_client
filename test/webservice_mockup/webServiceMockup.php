<?php
class webServiceMockup extends TingClientRequest{
  public function processResponse(stdClass $response) {
    return $response;
  }

  public function cacheEnable($value = NULL) {
    return FALSE;
  }

  public function cacheTimeout($value = NULL) {
    return 0;
  }

}