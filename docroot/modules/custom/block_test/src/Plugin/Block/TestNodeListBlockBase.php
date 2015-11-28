<?php

/**
 * @file
 * Contains \Drupal\block_test\Plugin\Block\TestBlock\TestNodeListBlockBase.
 */

namespace Drupal\block_test\Plugin\Block;


use Drupal\Core\Block\BlockBase;
use Drupal\Core\Database\Connection;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a base class for NodeList blocks.
 */
abstract class TestNodeListBlockBase extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The database object.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $database;

  /**
   * The entity storage.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected $entityStorage;

  /**
   * Construct a new TestNodeListBlockBase instance.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Database\Connection $database
   *   The database connection.
   * @param \Drupal\Core\Entity\EntityStorageInterface $entity_storage
   *   The entity storage.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, Connection $database, EntityStorageInterface $entity_storage) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->database = $database;
    $this->entityStorage = $entity_storage;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('database'),
      $container->get('entity_type.manager')->getStorage('node_type')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return array(
      'node_count' => 10,
      'node_bundles' => array(),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $result = $this->buildTestNodeListQuery()->execute();

    $elements = array();
    if ($node_title_list = node_title_list($result)) {
      $elements['node_list'] = $node_title_list;
    }

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    // @see buildConfigurationForm().
    $form['node_count'] = array(
      '#title' => t('Node count'),
      '#type' => 'textfield',
      '#default_value' => $this->configuration['node_count'],
      '#description' => $this->t('Number of items to display'),
    );

    $options = array();
    $node_types = $this->entityStorage->loadMultiple();
    foreach ($node_types as $type) {
      $options[$type->id()] = $type->label();
    }
    $form['node_bundles'] = array(
      '#title' => $this->t('Node types'),
      '#type' => 'checkboxes',
      '#options' => $options,
      '#default_value' => $this->configuration['node_bundles'],
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockValidate($form, FormStateInterface $form_state) {
    // @see validateConfigurationForm().
    if ($form_state->getValue('node_count') < 1) {
      $form_state->setErrorByName('node_count', $this->t('Node count should be greater than zero.'));

      // @todo: There seems to be some issue, setting the form error.
      // The form submit handler is skipped, but there is no error message.
      drupal_set_message($this->t('Node count should be greater than zero.'), 'error');
    }
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    // @see submitConfigurationForm().
    $this->setConfigurationValue('node_count', $form_state->getValue('node_count'));
    $this->setConfigurationValue('node_bundles', array_filter($form_state->getValue('node_bundles')));
  }

  /**
   * Builds the select query.
   *
   * @return \Drupal\Core\Database\Query\Select
   *   A Select object.
   */
  abstract protected function buildTestNodeListQuery();

}
