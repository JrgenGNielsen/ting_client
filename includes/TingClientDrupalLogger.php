<?php

/**
 * @file TingCLientDrupalLogger.php
 *
 * Class TingClientDrupalLogger
 *
 * Basically class wraps watchdog.
 */
class TingClientDrupalLogger extends TingClientLogger{
  protected function doLog($message, $variables, $severity) {
    watchdog('ting client', $message, $variables, $severity);
  }
}