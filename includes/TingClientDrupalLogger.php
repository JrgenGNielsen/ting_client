<?php

/**
 * @file TingCLientDrupalLogger.php
 *
 * Class TingClientDrupalLogger
 *
 * Basically class wraps watchdog.
 */
class TingClientDrupalLogger extends TingClientLogger{
  /**
   * @param $message_type
   * @param $variables
   *   array with variables [action, wsdlUrl,
   * @param $severity
   */
  public function doLog($message_type, $variables, $severity) {
    $variables['time'] = $this->log_time;
    $vars = array();
    foreach ($variables as $key => $value){
      $vars['@'.$key] = $value;
    }
    switch($message_type){
      case 'request_complete':
        $message = "Completed @clientType request: @action @wsdlUrl ( @time s)";
        break;
      case 'request_error':
        $message = "Error handling @clientType request @action @wsdlUrl: @error";
        break;
      default :
        $vars['@type'] = $message_type;
        $message = "@type request: @action @wsdlUrl ( @time s)";
    }
    if (!empty($variables['requestBody'])) {
      $message .= "<br/>\nRequest body: @requestBody";
    }
    if (!empty($variables['clientType']) && $variables['clientType'] == 'REST') {
      $message .= "<br/>\nParameters: @params";
    }

    watchdog('ting client', $message, $vars,
      constant('WATCHDOG_' . $severity),
      'http://' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
  }
}
