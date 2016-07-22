<?php

/**
 * @file
 * Contains \Drupal\dcamp_landing\Entity\DcampLanding.
 */

namespace Drupal\dcamp_landing\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\dcamp_landing\DcampLandingInterface;

/**
 * Defines the DrupalCamp Landing entity.
 *
 * @ConfigEntityType(
 *   id = "dcamp_landing",
 *   label = @Translation("DrupalCamp Landing"),
 *   handlers = {
 *     "list_builder" = "Drupal\dcamp_landing\DcampLandingListBuilder",
 *     "form" = {
 *       "add" = "Drupal\dcamp_landing\Form\DcampLandingForm",
 *       "edit" = "Drupal\dcamp_landing\Form\DcampLandingForm",
 *       "delete" = "Drupal\dcamp_landing\Form\DcampLandingDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\dcamp_landing\DcampLandingHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "dcamp_landing",
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid",
 *     "path" = "path",
 *     "blocks" = "blocks"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/dcamp_landing/{dcamp_landing}",
 *     "add-form" = "/admin/structure/dcamp_landing/add",
 *     "edit-form" = "/admin/structure/dcamp_landing/{dcamp_landing}/edit",
 *     "delete-form" = "/admin/structure/dcamp_landing/{dcamp_landing}/delete",
 *     "collection" = "/admin/structure/dcamp_landing"
 *   }
 * )
 */
class DcampLanding extends ConfigEntityBase implements DcampLandingInterface {
  /**
   * The DrupalCamp Landing ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The DrupalCamp Landing label.
   *
   * @var string
   */
  protected $label;

  /**
   * @var string
   */
  protected $path;

  /**
   * @var array
   */
  protected $blocks;

  /**
   * Get the path
   * @return string
   */
  public function getPath(){
    return $this->path;
  }

  /**
   * @return array
   */
  public function getBlocks(){
    return $this->blocks;
  }
}
