<?php
/**
 * @file
 * @todo add info.
 */


namespace Drupal\dcamp_landing\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Render\HtmlResponse;
use Drupal\dcamp_landing\Entity\DcampLanding;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class DcampLandingController extends ControllerBase {
  public function landing(DcampLanding $config){
    return [
      '#theme' => 'landing',
      '#blocks' => $config->getBlocks(),
      '#path' => $config->getPath(),
      '#label' => $config->label(),
      '#id' => $config->id(),
    ];
  }
}