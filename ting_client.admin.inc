<?php
/**
 * Form builder; Configure ting settings for this site.
 *
 * @ingroup forms
 * @see system_settings_form()
 */
function ting_client_admin_webservices_settings($form_state) {
  form_load_include($form_state, 'inc', 'ting', 'ting_client.admin');
  $form = array();

  $form['webservices'] = array(
    '#type' => 'fieldset',
    '#title' => t('client webservice settings'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
    '#tree' => FALSE,
  );

  $form['webservices']['ting_search_url'] = array(
    '#type' => 'textfield',
    '#title' => t('Search service URL'),
    '#description' => t('URL to the Ting search webservice, e.g. http://bibliotek.dk/openbibdk/next/'),
    '#required' => TRUE,
    '#default_value' => variable_get('ting_search_url', ''),
  );

  return $form;
}
