<?php
/**
 * Form builder; Configure settings for this site.
 *
 * @ingroup forms
 * @see system_settings_form()
 */
function ting_client_admin_webservices_settings($form_state) {
  $form = array();

  $form['webservice_client_enable_cache'] = array(
    '#title' => 'Enable all caches, overwrite (disable) for individual requests below',
    '#type' => 'checkbox',
    '#default_value' => variable_get('webservice_client_enable_cache', TRUE),
  );

  //@TODO add additional configuration to webservices in webservice hook
  // like this:  addi_config = array(name=>forsrights_name, pass=>forsrights_pass) etc.

  $webservices = ting_client_get_webservices();
  $cache_prefix = TingClientRequest::CACHEENABLE;
  $timeout_prefix = TingClientRequest::CACHELIFETIME;

  $form['ting_config'] = array(
    '#type' => 'fieldset',
    '#title' => 'Ting client settings',
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
    '#tree' => FALSE,
  );

  $form['ting_config']['ting_client_agency'] = array(
    '#type' => 'textfield',
    '#title' => t('Library code'),
    '#description' => t('The 6-digit code representing the library organization'),
    '#default_value' => variable_get('ting_client_agency', ''),
  );

  $form['ting_config']['ting_client_profile'] = array(
    '#type' => 'textfield',
    '#title' => t('Search profile'),
    '#description' => t('Profile name, used for filtering the search based on settings from vip.dbc.dk.'),
    '#default_value' => variable_get('ting_client_profile', ''),
  );


  foreach ($webservices as $name => $settings) {
    // check if webservice definition is valid
    if (ting_client_check_webservice_settings($name, $settings) === FALSE) {
      continue;
    }

    $form[$name] = array(
      '#type' => 'fieldset',
      '#title' => $name . ' ' . 'settings',
      '#collapsible' => TRUE,
      '#collapsed' => TRUE,
      '#tree' => FALSE,
    );

    $form[$name][$settings['class'] . '_url'] = array(
      '#type' => 'textfield',
      '#title' => $name . ' ' . 'URL',
      '#description' => t('URL to the %name webservice ', array('%name' => $name)),
      '#required' => TRUE,
      '#default_value' => variable_get($settings['class'] . '_url', ''),
    );

    $form[$name][$settings['class'] . $cache_prefix] = array(
      '#title' => t('Enable %name caches', array('%name' => $name)),
      '#type' => 'checkbox',
      '#default_value' => variable_get($settings['class'] . $cache_prefix),
    );

    $form[$name][$settings['class'] . $timeout_prefix] = array(
      '#title' => 'Cache lifetime',
      '#type' => 'textfield',
      '#default_value' => variable_get($settings['class'] . $timeout_prefix),
      '#description' => 'For how many minutes to cache',
    );

    if(isset($settings['xsd_url'])){
      $form[$name][$settings['class'] . '_xsd_url'] = array(
        '#title' => $name . ' XSD url',
        '#type' => 'textfield',
        '#default_value' => variable_get($settings['class'] . '_xsd_url', ''),
        '#required' => TRUE,
        '#description' => t('URL to the %name xsd ', array('%name' => $name)),
      );
    }
  }

  return system_settings_form($form);
}

/**
 * Check if given settings are valid.
 *
 * @param string $name
 * @param array  $settings
 *
 * @return bool
 */
function ting_client_check_webservice_settings($name, array $settings) {
  if (empty($settings['class'])) {
    drupal_set_message('No class for ' . $name, 'error');
    return FALSE;
  }

  if (empty($settings['url'])) {
    drupal_set_message('No URL for ' . $name, 'error');
    return FALSE;
  }

  return TRUE;
}


