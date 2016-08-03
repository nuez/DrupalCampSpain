<?php
/**
 * @file
 * Contains...
 */

namespace Drupal\dcamp\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Form\FormStateInterface;


/**
 * Provides a Description block with Countdown
 *
 * @Block(
 *   id = "dcamp_landing_info_with_countdown_block",
 *   admin_label = @Translation("Landing Info With Count Down Block")
 * )
 */
class DcampLandingInfoWithCountDownBlock extends BlockBase implements BlockPluginInterface{

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return ['label_display' => FALSE];
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = $this->getConfiguration();
    return [
      '#markup' => 'block!!' .$config['start_date'],
      '#cache' => [
        'max-age' => 0,
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form =  parent::blockForm($form, $form_state);

    $config = $this->getConfiguration();

    $form['start_date']  =[
      '#type' => 'date',
      '#title' => $this->t('Date'),
      '#default_value' => $config['start_date'],
    ];
    $form['translatable_text'] = [
      '#type' => 'text_format',
      '#title' => $this->t('Text area'),
      '#default_value' => $config['translatable_text_value'],
      '#format' => $config['translatable_text_format'],
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->setConfigurationValue('start_date', $form_state->getValue('start_date'));
    $this->setConfigurationValue('translatable_text_value', $form_state->getValue('translatable_text')['value']);
    $this->setConfigurationValue('translatable_text_format', $form_state->getValue('translatable_text')['format']);
  }
}
