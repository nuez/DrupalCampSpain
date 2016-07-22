<?php

/**
 * @file
 * Contains \Drupal\dcamp_landing\DcampLandingInterface.
 */

namespace Drupal\dcamp_landing;

use Drupal\Core\Config\Entity\ConfigEntityInterface;

/**
 * Provides an interface for defining DrupalCamp Landing entities.
 */
interface DcampLandingInterface extends ConfigEntityInterface {

  public function getPath();

}
