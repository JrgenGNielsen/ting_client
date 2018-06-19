<?php

/**
 * @file TingClientDrupalCacher.php
 *
 * Class TingClientDrupalCacher
 */
class TingClientDrupalCacher implements TingClientCacherInterface {

  /**
   * @var TingClientRequest
   */
  private $request;

  /**
   * Constructor
   *
   * @param \TingClientRequest $request
   */
  public function __construct(TingClientRequest $request) {
    $this->request = $request;
  }

  /**
   * Set cache.
   *
   * @param string $key
   * @param string $value
   */
  function set($key, $value) {
    $bin = $this->request->cacheBin();
    $timeout = ting_client_class::cacheTimeout($this->request);
    $expire = REQUEST_TIME + (60 * $timeout);
    cache_set($key, $value, $bin, $expire);
  }

  /**
   * Get from cache.
   *
   * @param string $key
   *
   * @return bool
   */
  function get($key) {
    $cache = cache_get($key, $this->request->cacheBin());
    // handle cache timeout
    if ($cache && $cache->expire > 0 && $cache->expire > REQUEST_TIME) {
      return $cache;
    }
    return FALSE;
  }

  /**
   * Clear cache
   */
  function clear() {
    cache_clear_all(NULL, $this->request->cacheBin());
  }
}