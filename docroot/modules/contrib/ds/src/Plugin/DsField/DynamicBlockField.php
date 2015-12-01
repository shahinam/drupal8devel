<?php

/**
 * @file
 * Contains \Drupal\ds\Plugin\DsField\DynamicBlockField.
 */

namespace Drupal\ds\Plugin\DsField;

use Drupal\ds\Plugin\DsField\DsFieldBase;

/**
 * Defines a generic dynamic block field.
 *
 * @DsField(
 *   id = "dynamic_block_field",
 *   deriver = "Drupal\ds\Plugin\Derivative\DynamicBlockField",
 *   provider = "block"
 * )
 */
class DynamicBlockField extends BlockBase {

  /**
   * {@inheritdoc}
   */
  protected function blockPluginId() {
    $definition = $this->getPluginDefinition();
    return $definition['properties']['block'];
  }

  /**
   * {@inheritdoc}
   */
  protected function blockConfig() {
    $block_config = array();
    $definition = $this->getPluginDefinition();
    if (isset($definition['properties']['config'])) {
      $block_config = $definition['properties']['config'];
    }
    return $block_config;
  }

}
