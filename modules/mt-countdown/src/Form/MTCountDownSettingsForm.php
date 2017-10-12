<?php

namespace Drupal\mt_countdown\Form;

use Drupal;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class MTCountDownSettingsForm.
 *
 * @package Drupal\mt_countdown\Form
 *
 * @ingroup mt_countdown
 */
class MTCountDownSettingsForm extends ConfigFormBase {

  /**
   * Returns a unique string identifying the form.
   *
   * @return string
   *   The unique string identifying the form.
   */
  public function getFormId() {
    return 'MTCountDown_settings';
  }

  /**
   * Form constructor.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   *
   * @return array
   *   The form structure.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $config = $this->config('mt_countdown.settings');
    $date = $config->get('expiration_date');
    $date_time = date("Y-m-d H:i:s", strtotime($date));

    $form['alert_message'] = [
      '#title' => $this->t('Message'),
      '#type' => 'textarea',
      '#required' => TRUE,
      '#default_value' => $config->get('alert_message'),
      '#placeholder' => $this->t('Enter the alert message.'),
    ];
    $form['expiration_date'] = [
      '#title' => $this->t('Expiration Date'),
      '#type' => 'datetime',
      '#required' => TRUE,
      '#date_date_format' => 'Y-m-d',
      '#date_time_format' => 'H:i:s',
      '#default_value' => DrupalDateTime::createFromFormat('Y-m-d H:i:s', $date_time, 'UTC'),
    ];
    $form['target_url'] = [
      '#title' => $this->t('Target URL'),
      '#type' => 'url',
      '#required' => TRUE,
      '#default_value' => $config->get('target_url'),
      '#placeholder' => $this->t('Target URL'),
    ];
    $form['dismiss_text'] = [
      '#title' => $this->t('Dismiss button text'),
      '#type' => 'textfield',
      '#required' => TRUE,
      '#default_value' => $config->get('dismiss_text'),
      '#placeholder' => $this->t('Got it!'),
    ];
    $form['predefined_palettes'] = [
      '#title' => $this->t('Choose a colour theme'),
      '#type' => 'select',
      '#required' => FALSE,
      '#default_value' => $config->get('predefined_palettes'),
      '#options' => [
        0 => $this->t('Custom'),
        1 => $this->t('Dark Yellow'),
        2 => $this->t('Light Green'),
        3 => $this->t('Dark Green'),
      ],
    ];
    $form['banner_colour'] = [
      '#prefix' => $this->t('<strong>Create your own Pallete</strong>'),
      '#title' => $this->t('Banner colour'),
      '#type' => 'color',
      '#required' => FALSE,
      '#default_value' => $config->get('banner_colour'),
      '#placeholder' => $this->t('#Banner'),
    ];
    $form['banner_text'] = [
      '#title' => $this->t('Banner text'),
      '#type' => 'color',
      '#required' => FALSE,
      '#default_value' => $config->get('banner_text'),
      '#placeholder' => $this->t('#Banner text'),
    ];
    $form['button_colour'] = [
      '#title' => $this->t('Button colour'),
      '#type' => 'color',
      '#required' => FALSE,
      '#default_value' => $config->get('button_colour'),
      '#placeholder' => $this->t('#Button'),
    ];
    $form['button_text'] = [
      '#title' => $this->t('Button text'),
      '#type' => 'color',
      '#required' => FALSE,
      '#default_value' => $config->get('button_text'),
      '#placeholder' => $this->t('#Button text'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * Form submission handler.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('mt_countdown.settings')
      ->set('alert_message', $form_state->getValue('alert_message'))
      ->set('expiration_date', $form_state->getValue('expiration_date')->format("Y-m-d H:i:s"))
      ->set('target_url', $form_state->getValue('target_url'))
      ->set('dismiss_text', $form_state->getValue('dismiss_text'))
      ->set('predefined_palettes', $form_state->getValue('predefined_palettes'))
      ->set('banner_colour', $form_state->getValue('banner_colour'))
      ->set('banner_text', $form_state->getValue('banner_text'))
      ->set('button_colour', $form_state->getValue('button_colour'))
      ->set('button_text', $form_state->getValue('button_text'))
      ->save();

    // Clear routing and links cache.
    Drupal::service("router.builder")->rebuild();

    parent::submitForm($form, $form_state);

  }

  /**
   * Gets the configuration names that will be editable.
   *
   * @return array
   *   An array of configuration object names that are editable if called in
   *   conjunction with the trait's config() method.
   */
  protected function getEditableConfigNames() {
    return [
      'mt_countdown.settings',
    ];
  }
}
