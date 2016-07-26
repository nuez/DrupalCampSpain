<?php
/**
 * @file
 * @todo add info.
 */


namespace Drupal\dcamp_landing\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\dcamp_landing\Entity\DcampLanding;


class DcampLandingController extends ControllerBase{
  public function landing(DcampLanding $config){
    return ['#markup' => 'test'];
  }
}