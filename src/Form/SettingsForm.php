<?php

namespace Drupal\dpa_digital_wires\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\field\Entity\FieldConfig;

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
    $storage = \Drupal::entityTypeManager()->getStorage('node_type');
    $types = $storage->loadMultiple();
    $options = [];
    foreach($types as $type) {
      $options[$type->id()] = $type->label();
    };
    $default = $this->config('dpa_digital_wires.settings')->get('content_type');
    $form['content_type'] = [
      '#type' => 'radios',
      '#title' => $this->t('Content Type'),
      '#description'=> $this->t('Select the content type new articles should be created in.'),
      '#options' => $options,
      '#default_value'=>$default,
    ];

    /** @var \Drupal\Core\Entity\EntityFieldManager $fieldManager */
    $fieldManager = \Drupal::service('entity_field.manager');
    /** @var FieldConfig[] $fields */
    $fields = $fieldManager->getFieldDefinitions('node',$default);
    $fields = array_filter($fields,function($element) { return $element instanceof FieldConfig;});

    $options = ['__'=>'Ignore'];
    foreach($fields as $key=>$field) {
      if($field->getType()=='string') {
        $options[$key]=$field->label();
      }
    }
    $form['byline_destination']=[
      '#type'=>'select',
      '#title'=>$this->t('Byline field'),
      '#description'=>$this->t('This field will contain the imported articles byline'),
      '#options'=>$options,
      '#default_value'=>$config->get('byline_destination'),
    ];

    $options = ['__'=>'Ignore'];
    foreach($fields as $key=>$field) {
      if($field->getType()=='string') {
        $options[$key]=$field->label();
      }
    }
    $form['copyrightnotice_destination']=[
      '#type'=>'select',
      '#title'=>$this->t('Copyright notice field'),
      '#description'=>$this->t('This field will contain the imported articles copyright notice'),
      '#options'=>$options,
      '#default_value'=>$config->get('copyrightnotice_destination'),
    ];

    $options = ['__'=>'Ignore'];
    foreach($fields as $key=>$field) {
      if($field->getType()=='string') {
        $options[$key]=$field->label();
      }
    }
    $form['dateline_destination']=[
      '#type'=>'select',
      '#title'=>$this->t('Dateline field'),
      '#description'=>$this->t('This field will contain the imported articles dateline'),
      '#options'=>$options,
      '#default_value'=>$config->get('dateline_destination'),
    ];

    $options = ['__'=>'Ignore'];
    foreach($fields as $key=>$field) {
      if($field->getType()=='string') {
        $options[$key]=$field->label();
      }
    }
    $form['dpaurn_destination']=[
      '#type'=>'select',
      '#title'=>$this->t('DPA URN field'),
      '#description'=>$this->t('This field will contain the imported articles URN'),
      '#options'=>$options,
      '#default_value'=>$config->get('dpaurn_destination'),
    ];


    $options = ['__'=>'Ignore'];
    foreach($fields as $key=>$field) {
      if($field->getType()=='string') {
        $options[$key]=$field->label();
      }
    }
    $form['headline_destination']=[
      '#type'=>'select',
      '#title'=>$this->t('Headline field'),
      '#description'=>$this->t('This field will contain the imported articles headline'),
      '#options'=>$options,
      '#default_value'=>$config->get('headline_destination'),
    ];

    $options = ['__'=>'Ignore'];
    foreach($fields as $key=>$field) {
      if($field->getType()=='string') {
        $options[$key]=$field->label();
      }
    }
    $form['kicker_destination']=[
      '#type'=>'select',
      '#title'=>$this->t('Kicker field'),
      '#description'=>$this->t('This field will contain the imported articles kicker'),
      '#options'=>$options,
      '#default_value'=>$config->get('kicker_destination'),
    ];

    $options = ['__'=>'Ignore'];
    foreach($fields as $key=>$field) {
      if($field->getType()=='string_long') {
        $options[$key]=$field->label();
      }
    }
    $form['teaser_destination']=[
      '#type'=>'select',
      '#title'=>$this->t('Teaser field'),
      '#description'=>$this->t('This field will contain the imported articles teaser'),
      '#options'=>$options,
      '#default_value'=>$config->get('teaser_destination'),
    ];

    $options = ['__'=>'Ignore'];
    foreach($fields as $key=>$field) {
      if($field->getType()=='entity_reference') {
        $settings = $field->getSettings();
        if($settings['handler'] == 'default:media') {
          $options[$key]=$field->label();
        }
      }
    }
    $form['image_destination']=[
      '#type'=>'select',
      '#title'=>$this->t('Image field'),
      '#description'=>$this->t('This field will contain the imported articles images. Will generate image media entities and referene those'),
      '#options'=>$options,
      '#default_value'=>$config->get('image_destination'),
    ];

    $formats = filter_formats();
    $options=[];
    foreach ($formats as $format) {
      $options[$format->id()] = $format->label();
    }
    $form['body_format']=[
      '#type'=>'select',
      '#title'=>$this->t('Body field format'),
      '#description'=>$this->t('Input format to be used for the body'),
      '#options'=>$options,
      '#default_value'=>$config->get('body_format'),
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
      ->set('content_type',$form_state->getValue('content_type'))
      ->set('byline_destination',$form_state->getValue('byline_destination'))
      ->set('copyrightnotice_destination',$form_state->getValue('copyrightnotice_destination'))
      ->set('dateline_destination',$form_state->getValue('dateline_destination'))
      ->set('dpaurn_destination',$form_state->getValue('dpaurn_destination'))
      ->set('headline_destination',$form_state->getValue('headline_destination'))
      ->set('kicker_destination',$form_state->getValue('kicker_destination'))
      ->set('teaser_destination',$form_state->getValue('teaser_destination'))
      ->set('image_destination',$form_state->getValue('image_destination'))
      ->set('body_format',$form_state->getValue('body_format'))
      ->save();
    drupal_flush_all_caches();
  }

}
