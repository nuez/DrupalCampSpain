<?php
/**
 * @file
 * @todo add info.
 */


namespace Drupal\dcamp\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\dcamp\Entity\Dcamp;


class DcampController extends ControllerBase {
  public function landing(Dcamp $dcamp_entity){
    return [
      '#markup' => 'test',
    ];
  }
}