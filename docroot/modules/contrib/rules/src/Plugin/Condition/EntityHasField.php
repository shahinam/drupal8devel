<?php

/**
 * @file
 * Contains \Drupal\rules\Plugin\Condition\EntityHasField.
 */

namespace Drupal\rules\Plugin\Condition;

use Drupal\rules\Core\RulesConditionBase;

/**
 * Provides a 'Entity has field' condition.
 *
 * @Condition(
 *   id = "rules_entity_has_field",
 *   label = @Translation("Entity has field"),
 *   category = @Translation("Entity"),
 *   context = {
 *     "entity" = @ContextDefinition("entity",
 *       label = @Translation("Entity"),
 *       description = @Translation("Specifies the entity for which to evaluate the condition.")
 *     ),
 *     "field" = @ContextDefinition("string",
 *       label = @Translation("Field"),
 *       description = @Translation("The name of the field to check for.")
 *     )
 *   }
 * )
 *
 * @todo: Add access callback information from Drupal 7.
 */
class EntityHasField extends RulesConditionBase {

  /**
   * {@inheritdoc}
   */
  public function evaluate() {
    $entity = $this->getContextValue('entity');
    $field = $this->getContextValue('field');
    return $entity->hasField($field);
  }

}
