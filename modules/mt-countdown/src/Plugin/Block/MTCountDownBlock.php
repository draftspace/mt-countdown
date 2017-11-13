<?php
namespace Drupal\mt_countdown\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'MTCountDown' Block.
 *
 * @Block(
 *   id = "mt_countdown",
 *   admin_label = @Translation("CountDown block"),
 * )
 */
class MTCountDownBlock extends BlockBase implements BlockPluginInterface {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = \Drupal::config('mt_countdown.settings');
    $data = [];
    $data['title'] = $config->get('title');
    $data['alert_message'] = $config->get('alert_message');
    $data['days_to'] = $config->get('days_to');
    $data['target_url'] = $config->get('target_url');
    $data['dismiss_text'] = $config->get('dismiss_text');
    // Color settings.
    $data['background'] = $config->get('background');
    $data['title_color'] = $config->get('title_color');
    $data['message_color'] = $config->get('message_color');
    $data['notes_color'] = $config->get('notes_color');
    $data['button_background'] = $config->get('button_background');
    $data['button_color'] = $config->get('button_color');
    return [
      '#theme' => 'mt_countdown',
      '#data' => $data,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $config = $this->getConfiguration();

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['mt_countdown_block_settings'] = $form_state->getValue('mt_countdown_block_settings');
  }
}