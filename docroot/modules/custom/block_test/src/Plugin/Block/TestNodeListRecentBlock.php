<?php

/**
 * @file
 * Contains \Drupal\block_test\Plugin\Block\TestBlock\TestNodeListRecentBlock.
 */

namespace Drupal\block_test\Plugin\Block;


/**
 * Provides a 'Recent Nodes' block.
 *
 * @Block(
 *  id = "test_node_list_recent_block",
 *  admin_label = @Translation("Test Node List Recent"),
 *  category = @Translation("Test"),
 * )
 */
class TestNodeListRecentBlock extends TestNodeListBlockBase {

  /**
   * {@inheritdoc}
   */
  protected function buildTestNodeListQuery() {
    $query = $this->database->select('node', 'n');
    $query->join('node_field_data', 'nfd', 'n.nid = nfd.nid');

    if ($types = $this->configuration['node_bundles']) {
      $query->condition('nfd.type', $types, 'IN');
    }

    return $query->fields('n')
      ->fields('nfd')
      ->addTag('node_access')
      ->addMetaData('base_table', 'node')
      ->orderBy('nfd.created', 'DESC')
      ->range(0, $this->configuration['node_count']);
  }

}
