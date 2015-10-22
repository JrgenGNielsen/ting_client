<?php
/**
 * Form builder; Configure settings for this site.
 *
 * @ingroup forms
 * @see system_settings_form()
 */
function ting_client_admin_webservices_settings($form_state) {
  $form = array();

  // @TODO this can be done as a loop on webservices.
  // like this:
  // $webservices = ting_client_get_webservices();
  // foreach ($webservices .....

  $form['forsrights'] = array(
    '#type' => 'fieldset',
    '#title' => t('Forsrights settings'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
    '#tree' => FALSE,
  );

  $form['forsrights']['bibdk_forsrights_url'] = array(
    '#type' => 'textfield',
    '#title' => t('forsrights URL'),
    '#description' => t('URL to the forsrights webservice, e.g. http://forsrights.addi.dk/'),
    '#required' => TRUE,
    '#default_value' => variable_get('bibdk_forsrights_url', ''),
  );

  // @TODO add cache control

  return system_settings_form($form);
}
