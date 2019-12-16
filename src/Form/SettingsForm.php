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
    $form['wireq_base_url'] = [
      '#type' => 'textarea',
      '#title' => $this->t('wireQ base-URL'),
      '#description' => $this->t('The base-URL for your wireQ feed, which you can activate in the dpa API-Portal.'),
      '#default_value' => $config->get('wireq_base_url'),
    ];
    $form['publishing_status'] = [
      '#type' => 'radios',
      '#title' => $this->t('Publishing status'),
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
      ->set('wireq_base_url', $form_state->getValue('wireq_base_url'))
      ->set('publishing_status', $form_state->getValue('publishing_status'))
      ->save();
  }

}
