<?php

/**
 * @file
 * Contains \Drupal\assets_test\Controller\AssetsTestController.
 */

namespace Drupal\assets_test\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class AssetsTestController.
 *
 * @package Drupal\assets_test\Controller
 */
class AssetsTestController extends ControllerBase {
  /**
   * Index.
   *
   * @return string
   *   Return Hello string.
   */
  public function index() {
    $list = [];
    for ($i = 1; $i <= 10; $i++) {
      $list[] = $this->t('<h2 class="list-item">Item #@id</h2>', ['@id' => $i]);
    }

    $build = [];
    $build['list'] = [
      '#theme' => 'item_list',
      '#items' => $list,
    ];

    $build['#attached']['library'][] = 'assets_test/assets_test.list';

    $build['#attached']['drupalSettings']['assets_test']['append'] = '(Done)';

    return $build;
  }

}
