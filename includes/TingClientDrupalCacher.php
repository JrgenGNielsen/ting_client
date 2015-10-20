<?php

class TingClientDrupalCacher implements TingClientCacherInterface {

  /**
   * @var TingClientRequest
   */
  private $request;

  public function __construct(TingClientRequest $request) {
    $this->request = $request;
  }

  private function cacheEnable() {
    $class_name = get_class($this->request);
    return variable_get($class_name . TingClientRequest::CACHEENABLE);
  }

  private function cacheTimeOut() {
    $class_name = get_class($this->request);
    return variable_get($class_name . TingClientRequest::CACHELIFETIME);
  }

  function set($key, $value) {
    cache_set($key, $value);
    // TODO: Implement set() method.
  }

  function get($key) {
    return FALSE;
    // TODO: Implement get() method.
  }

  function clear() {
    // TODO: Implement clear() method.
  }

}