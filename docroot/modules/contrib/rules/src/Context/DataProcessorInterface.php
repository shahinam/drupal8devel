<?php

/**
 * @file
 * Contains \Drupal\rules\Context\DataProcessorInterface.
 */

namespace Drupal\rules\Context;

use Drupal\rules\Engine\RulesStateInterface;

/**
 * Interface for Rules data processor plugins.
 */
interface DataProcessorInterface {

  /**
   * Process the given value.
   *
   * @param mixed $value
   *   The value to process.
   * @param \Drupal\rules\Engine\RulesStateInterface $rules_state
   *   The current Rules execution state containing all context variables.
   *
   * @return mixed
   *   The processed value. Since the value can also be a primitive data type
   *   (a string for example) this function must return the value.
   */
  public function process($value, RulesStateInterface $rules_state);

}
