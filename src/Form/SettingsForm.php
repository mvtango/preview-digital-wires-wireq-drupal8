<?php

namespace Drupal\dpa_digital_wires\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class SettingsForm.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'dpa_digital_wires.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('dpa_digital_wires.settings');
    $form['dpa_api_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('dpa API key'),
      '#description' => $this->t('The API to fetch the available articles from the dpa.'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('dpa_api_key'),
    ];
    $form['publishing_status'] = [
      '#type' => 'radios',
      '#title' => $this->t('Publishing status for new articles'),
      '#description' => $this->t('Select wether new articles should be published automatically.'),
      '#options' => ['Draft' => $this->t('Draft'), 'Published' => $this->t('Published')],
      '#default_value' => 'Draft',
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('dpa_digital_wires.settings')
      ->set('dpa_api_key', $form_state->getValue('dpa_api_key'))
      ->set('publishing_stage', $form_state->getValue('publishing_stage'))
      ->save();
  }

}
