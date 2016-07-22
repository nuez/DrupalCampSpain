<?php

/**
 * @file
 * Contains \Drupal\dcamp_landing\DcampLandingListBuilder.
 */

namespace Drupal\dcamp_landing;

use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Entity\EntityInterface;

/**
 * Provides a listing of DrupalCamp Landing entities.
 */
class DcampLandingListBuilder extends ConfigEntityListBuilder {
  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['label'] = $this->t('DrupalCamp Landing');
    $header['id'] = $this->t('Machine name');
    $header['path'] = $this->t('Path');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(DcampLandingInterface $entity) {
    $row['label'] = $entity->label();
    $row['id'] = $entity->id();
    $row['path'] = $entity->getPath();
    // You probably want a few more properties here...
    return $row + parent::buildRow($entity);
  }

}
