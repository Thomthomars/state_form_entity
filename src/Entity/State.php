<?php

namespace Drupal\state\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines a State configuration entity class.
 *
 * @ConfigEntityType(
 *   id = "state",
 *   label = @Translation("State"),
 *   fieldable = FALSE,
 *   handlers = {
 *     "list_builder" = "Drupal\state\StateListBuilder",
 *     "form" = {
 *       "add" = "Drupal\state\Form\StateForm",
 *       "edit" = "Drupal\state\Form\StateForm",
 *       "delete" = "Drupal\state\Form\StatDeleteForm"
 *     }
 *   },
 *   config_prefix = "state",
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "id" = "type",
 *     "label" = "name",
 *   },
 *   links = {
 *     "edit-form" = "/admin/structure/state/edit/{type}",
 *     "delete" = "/admin/structure/state/delete/{type}",
 *   },
 *   config_export = {
 *     "name",
 *     "type",
 *     "description",
 *     "formFieldParent",
 *     "fieldTarget",
 *     "fieldToggle",
 *     "stateTypeElement",
 *     "statesType",
 *     "valueNested",
 *   }
 * )
 */
class State extends ConfigEntityBundleBase {

  /**
   * The field name toggle.
   *
   * @var string
   */
  public $name;

  /**
   * The entity type id.
   *
   * @var $entityTypeId
   */
  public $type;

  /**
   * A brief description of this node type.
   *
   * @var string
   */
  protected $description;

  /**
   * The form handle field.
   *
   * @var string
   */
  public $formFieldParent;

  /**
   * The field target.
   *
   * @var string
   */
  public $fieldTarget;

  /**
   * The field target.
   *
   * @var string
   */
  public $fieldToggle;

  /**
   * The different states behaviors.
   *
   * @var array
   */
  public $stateTypeElement;

  /**
   * The different states behaviors.
   *
   * @var array
   */
  public $statesType;

  /**
   * The ajax behaviors callback.
   *
   * @var array
   */
  public $valueNested;

  /**
   * @return mixed
   */
  public function id() {
    return $this->type;
  }

  /**
   * Get the name.
   *
   * @return mixed
   *   The name or null.
   */
  public function getName() {
    return $this->name;
  }

  /**
   * Set the name.
   *
   * @param mixed $name
   *   The name from form.
   */
  public function setName($name) {
    $this->name = $name;
  }

  /**
   * @return string
   */
  public function getFormFieldParent() {
    return $this->formFieldParent;
  }

  /**
   * @param string $formFieldParent
   */
  public function setFormFieldParent($formFieldParent) {
    $this->formFieldParent = $formFieldParent;
  }

  /**
   * @return string
   */
  public function getFieldTarget() {
    return $this->fieldTarget;
  }

  /**
   * @param string $fieldTarget
   */
  public function setFieldTarget($fieldTarget) {
    $this->fieldTarget = $fieldTarget;
  }

  /**
   * @return string
   */
  public function getFieldToggle() {
    return $this->fieldToggle;
  }

  /**
   * @param string $fieldToggle
   */
  public function setFieldToggle($fieldToggle) {
    $this->fieldToggle = $fieldToggle;
  }

  /**
   * @return array
   */
  public function getStateTypeElement() {
    return $this->stateTypeElement;
  }

  /**
   * @param array $stateTypeElement
   */
  public function setStateTypeElement($stateTypeElement) {
    $this->stateTypeElement = $stateTypeElement;
  }

  /**
   * Get the states.
   *
   * @return mixed
   *   The states or null.
   */
  public function getStatesType() {
    return $this->statesType;
  }

  /**
   * Set the states.
   *
   * @param mixed $states
   *   The states from form.
   */
  public function setStatesType($statesType) {
    $this->statesType = $statesType;
  }

  /**
   * Get value to toggle.
   *
   * @return mixed
   *   Get field toggle.
   */
  public function getValueNested() {
    return $this->valueNested;
  }

  /**
   * Set the value field toggle.
   *
   * @param mixed $valueNested
   *   Set the value field toggle from form.
   */
  public function setValueNested($valueNested) {
    $this->valueNested = $valueNested;
  }

}