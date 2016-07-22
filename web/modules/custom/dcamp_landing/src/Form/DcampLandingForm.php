<?php
/**
 * @file
 * Contains \Drupal\dcamp_landing\Form\DcampLandingForm.
 */

namespace Drupal\dcamp_landing\Form;

use Drupal\block\Entity\Block;
use Drupal\Core\Entity\Element\EntityAutocomplete;
use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Element;
use Drupal\Core\Url;

/**
 * Class DcampLandingForm.
 *
 * @package Drupal\dcamp_landing\Form
 */
class DcampLandingForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $dcamp_landing = $this->entity;

    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $dcamp_landing->label(),
      '#description' => $this->t("Label for the DrupalCamp Landing."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $dcamp_landing->id(),
      '#machine_name' => [
        'exists' => '\Drupal\dcamp_landing\Entity\DcampLanding::load',
      ],
      '#disabled' => !$dcamp_landing->isNew(),
    ];

    $form['path'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Route for landing page'),
      '#maxlength' => 50,
      '#default_value' => !empty($dcamp_landing->getPath()) ? $dcamp_landing->getPath() : 'base:',
      '#required' => TRUE,
      '#element_validate' => [[$this, 'validatePath']],
      '#description' => $this->t('A base path to the landing page.')
    ];


    $form['blocks'] = [
      '#attributes' => ['id' => 'landings-block'],
      '#type' => 'fieldset',
      '#element_validate' => [[$this, 'validateBlocks']],
      'rows' => [
        '#type' => 'table',
        '#header' => [$this->t('Blocks'), $this->t('Weight')],
        '#empty' => t('There are no items yet'),
        '#tableselect' => FALSE,
        '#tabledrag' => [
          [
            'action' => 'order',
            'relationship' => 'sibling',
            'group' => 'weight',
          ]
        ],
      ],
      'actions' => [
        'add_row' => [
          '#type' => 'submit',
          '#value' => t('Add one more'),
          '#submit' => ['::addRowSubmit'],
          '#ajax' => [
            'callback' => '::addRowCallback',
            'wrapper' => 'landings-block',
          ],
        ],
      ]
    ];

    $num_rows = $form_state->get('num_rows');
    $blocks = $dcamp_landing->getBlocks();
    foreach($blocks as $block){
      $form['blocks']['rows'][] = $this->getRow($block['block'], $block['weight']);
    }

    for($i = count($blocks); $i < $num_rows; $i++){
      $form['blocks']['rows'][] = $this->getRow();
    }

    return $form;
  }

  /**
   * Validates the Path
   */
  public static function validatePath(&$element, FormStateInterface $form_state, &$complete_form) {
    $path = $element['#value'];
    try {
      $url = Url::fromUri($path);
      $form_state->setValueForElement($element, $url->getUri());
    } catch (\Exception $e) {
      $form_state->setError($element, t('Please enter a valid internal path for the landing page.'));
    }
  }

  /**
   * Validates the blocks.
   */
  public static function validateBlocks(&$element, FormStateInterface $form_state, &$complete_form){
    $values =  $form_state->getValue('rows');
    $form_state->setValueForElement($element,$values);
  }
  
  /**
   * Add a row using ajax.
   */
  public function addRowCallback($form, FormStateInterface $form_state) {
    return $form['blocks'];
  }

  /**
   * Get row for block selection table.
   * @return array
   */
  private function getRow($block = '', $weight = 0) {
    $element = [
      '#attributes' => ['class' => ['draggable']],
      '#weight' => 0,
      'block' => [
        '#type' => 'entity_autocomplete',
        '#target_type' => 'block',
        '#default_value' => Block::load($block),
      ],
      'weight' => [
        '#type' => 'weight',
        '#title' => t('Weight'),
        '#title_display' => 'invisible',
        '#default_value' => $weight,
        '#attributes' => ['class' => ['weight']],
      ],
    ];
    return $element;
  }

  /**
   * Submit handler for the "add-one-more" button.
   */
  public function addRowSubmit(array &$form, FormStateInterface $form_state) {
    $form_state->set('num_rows', $form_state->get('num_rows') + 1);
    $form_state->setRebuild();
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $dcamp_landing = $this->entity;
    $status = $dcamp_landing->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label DrupalCamp Landing.', [
          '%label' => $dcamp_landing->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label DrupalCamp Landing.', [
          '%label' => $dcamp_landing->label(),
        ]));
    }
    $form_state->setRedirectUrl($dcamp_landing->urlInfo('collection'));
  }

}
