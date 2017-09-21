<?php

namespace Drupal\state;

use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Entity\EntityInterface;

/**
 * Defines a class to build a listing of states entities.
 *
 * @see \Drupal\state\Entity\State
 */
class StateListBuilder extends ConfigEntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['label'] = $this->t('Name');
    $header['type'] = $this->t('Type');
    $header['description'] = $this->t('Description');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /** @var $entity \Drupal\state\Entity\State */
    // Label
    $row['label'] = $this->getLabel($entity);

    // Color
    $row['type'] = $entity->id();

    // Description
    $row['type'] = $entity->id();


    return $row + parent::buildRow($entity);
  }

  /**
   * {@inheritdoc}
   */
  public function render() {

    $build = parent::render();

    $build['#empty'] = $this->t('There are no state type available.');
    return $build;
  }

}
