<?php

/**
 * @file
 * Contains \Drupal\block_test\Plugin\Block\TestBlock.
 */

namespace Drupal\block_test\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Session\AccountInterface;

/**
 * Provides a 'TestBlock' block.
 *
 * @Block(
 *  id = "test_block",
 *  admin_label = @Translation("Test block"),
 *  category = @Translation("Test"),
 * )
 */
class TestBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $build['test_block']['#markup'] = 'This is a test block.';

    return $build;
  }

  /**
   * {@inheritdoc}
   */
  protected function blockAccess(AccountInterface $account) {
    // @see $this->access() how it is used.
    return AccessResult::allowedIf($account->isAuthenticated());
  }

}
