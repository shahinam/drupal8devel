<?php

/**
 * @file
 * Contains \Drupal\rules\Tests\RulesDrupalTestBase.
 */

namespace Drupal\Tests\rules\Kernel;

use Drupal\Component\FileCache\FileCacheFactory;
use Drupal\Core\Site\Settings;
use Drupal\KernelTests\KernelTestBase;

/**
 * Base class for Rules Drupal unit tests.
 */
abstract class RulesDrupalTestBase extends KernelTestBase {

  /**
   * The expression plugin manager.
   *
   * @var \Drupal\rules\Engine\ExpressionManager
   */
  protected $expressionManager;

  /**
   * The condition plugin manager.
   *
   * @var \Drupal\Core\Condition\ConditionManager
   */
  protected $conditionManager;

  /**
   * The typed data manager.
   *
   * @var \Drupal\Core\TypedData\TypedDataManager
   */
  protected $typedDataManager;

  /**
   * Rules logger.
   *
   * @var \Drupal\rules\Logger\RulesLoggerChannel
   */
  protected $logger;

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = ['rules', 'rules_test', 'system'];

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    // @todo Extra hack to avoid test fails, remove this once
    // https://www.drupal.org/node/2553661 is fixed.
    FileCacheFactory::setPrefix(Settings::getApcuPrefix('file_cache', $this->root));

    parent::setUp();

    $this->logger = $this->container->get('logger.channel.rules');
    // Clear the log from any stale entries that are bleeding over from previous
    // tests.
    $this->logger->clearLogs();

    $this->expressionManager = $this->container->get('plugin.manager.rules_expression');
    $this->conditionManager = $this->container->get('plugin.manager.condition');
    $this->typedDataManager = $this->container->get('typed_data_manager');
  }

  /**
   * Creates a new condition.
   *
   * @param string $id
   *   The condition plugin id.
   *
   * @return \Drupal\rules\Core\RulesConditionInterface
   *   The created condition plugin.
   */
  protected function createCondition($id) {
    $condition = $this->expressionManager->createInstance('rules_condition', [
      'condition_id' => $id,
    ]);
    return $condition;
  }

  /**
   * Checks if particular message is in the log with given delta.
   *
   * @param string $message
   *   Log message.
   * @param int $log_item_index
   *   Log item's index in log entries stack.
   */
  protected function assertRulesLogEntryExists($message, $log_item_index = 0) {
    // Test that the action has logged something.
    $logs = $this->logger->getLogs();
    $this->assertEqual($logs[$log_item_index]['message'], $message);
  }

}
