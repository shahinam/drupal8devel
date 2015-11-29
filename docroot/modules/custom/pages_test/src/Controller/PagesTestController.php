<?php

/**
 * @file
 * Contains \Drupal\pages_test\Controller\PagesTestController.
 */

namespace Drupal\pages_test\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Session\AccountProxy;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Class PagesTestController.
 *
 * @package Drupal\pages_test\Controller
 */
class PagesTestController extends ControllerBase {

  /**
   * The logged in user.
   *
   * @var \Drupal\Core\Session\AccountProxy
   */
  protected $current_user;

  /**
   * {@inheritdoc}
   */
  public function __construct(AccountProxy $current_user) {
    $this->current_user = $current_user;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('current_user')
    );
  }

  /**
   * Index page.
   *
   * @return array
   */
  public function index() {
    $build = [];

    $build[] = [
      '#type' => 'markup',
      '#markup' => $this->t('Welcome <em>@user</em>', ['@user' => $this->current_user->getAccountName()]),
      '#prefix' => '<div>',
      '#suffix' => '</div>',
    ];

    // Generate page number list.
    $list = [];
    for ($id = 1; $id <= 10; $id++) {
      $url = Url::fromRoute('pages_test.info', ['id' => $id]);
      $list[] = $this->l($this->t('page #@page_number', ['@page_number' => $id]), $url);
    }

    $build['page_links'] = array(
      '#theme' => 'item_list',
      '#items' => $list,
      '#title' => $this->t('Page Links'),
    );

    // Override title.
    // Though not recommended to override here.
    $build['#title'] = 'Pages Test Index';

    return $build;
  }

  /**
   * Info page Content.
   *
   * @param $id
   *    Page ID.
   *
   * @return array
   *    Render array.
   *
   * @throws \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException
   *    If argument is invalid.
   */
  public function infoContent($id) {
    // Make sure we have valid argument.
    if (!is_numeric($id)) {
      // Show access denied page.
      throw new AccessDeniedHttpException();
    }

    $index_page = Url::fromRoute('pages_test.index');
    return [
      [
        '#type' => 'markup',
        '#markup' => $this->t('This is page #@page_number', ['@page_number' => $id]),
        '#prefix' => '<div>',
        '#suffix' => '</div>',
      ],
      [
        '#type' => 'markup',
        '#markup' => $this->l($this->t('< Back to index page'), $index_page),
        '#prefix' => '<div>',
        '#suffix' => '</div>',
      ],
    ];
  }

  /**
   * @param $id
   *    Page ID.
   *
   * @return string
   *    Page title.
   */
  public function infoTitle($id) {
    return 'Page #' . $id;
  }

}
