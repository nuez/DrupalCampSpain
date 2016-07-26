<?php

namespace Drupal\dcamp_landing\Routing;

use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Entity\Query\QueryFactory;
use Drupal\dcamp_landing\Entity\DcampLanding;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\Route;

/**
 * Defines DrupalCamp Landing Routes based on the Landing Config Entities.
 */
class DcampLandingRoutes implements ContainerInjectionInterface {

  /**
   * @var QueryFactory
   */
  protected $queryFactory;

  public function __construct(QueryFactory $query_factory) {
    $this->queryFactory = $query_factory;
  }

  public static function create(ContainerInterface $container) {
    return new static (
      $container->get('entity.query')
    );
  }

  public function routes() {
    $landings = $this->queryFactory->get('dcamp_landing')->execute();
    $routes = [];
    foreach ($landings as $landing) {
      $config = DcampLanding::load($landing);
      $routes[$landing] = new Route(
        $config->getPath(),
        array(
          '_controller' => 'Drupal\dcamp_landing\Controller\DcampLandingController::landing',
          'config' => $config,
        ),
        array(
          '_access' => 'TRUE',
        )
      );
    }

    return $routes;
  }
}