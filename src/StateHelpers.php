<?php

namespace Drupal\state;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class StateHelpers
 * @package Drupal\state
 */
class StateHelpers {

  /**
   * @var
   */
  protected $entity_type_manager;

  /**
   * The following states may be applied to an element:
   */
  const STATE_ELEMENTS = [
    'enabled' => 'enabled',
    'disabled' => 'disabled',
    'required' => 'required',
    'optional'=> 'optional',
    'visible'=> 'visible',
    'invisible' => 'invisible',
    'checked' => 'checked',
    'unchecked' => 'unchecked',
    'expanded' => 'expanded',
    'collapsed' => 'collapsed',
  ];

  const STATE_ELEMENTSS = [
    'enabled',
    'disabled',
    'required',
    'optional',
    'visible',
    'invisible',
    'checked',
    'unchecked',
    'expanded',
    'collapsed',
  ];

  /**
   * The following states may be used in remote conditions:
   */
  const STATE_REMOTE = [
    'empty' => 'empty',
    'filled' => 'filled',
    'checked' => 'checked',
    'unchecked' => 'unchecked',
    'expanded' => 'expanded',
    'collapsed' => 'collapsed',
    'value' => 'value',
  ];

  /**
   * The following states exist for both elements and remote conditions, but are
   * not fully implemented and may not change anything on the element:
   */
  const STATE_PROBABLY_USELESS = [
    'relevant' => 'relevant',
    'irrelevant' => 'irrelevant',
    'valid' => 'valid',
    'invalid' => 'invalid',
    'touched' => 'touched',
    'untouched' => 'untouched',
    'readwrite' => 'readwrite',
    'readonly' => 'readonly',
  ];

/*
  public function __construct(EntityTypeManagerInterface $entityTypeManager) {
    $this->entity_type_manager = $entityTypeManager;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager')
    );
  }
*/

  /**
   * @param $selected
   * @return mixed
   */
  public static function getStateList($selected) {
    return constant("self::$selected");
  }

  public static function HandlerFormStates(array &$form, FormStateInterface $form_state, $form_id) {
    self::handlerStatesElements($form, $form_state, $form_id);
  }

  /**
   * Get and create element behaviors need in form.
   *
   * @param array $form
   *   The form parent element.
   *
   * @return mixed
   *   The form.
   */
  public static function handlerStatesElements(array &$form, FormStateInterface $form_state, $form_id) {
    // Handle show hide effect.
    $states = \Drupal::entityTypeManager()->getStorage('state')->loadMultiple();

    $fieldPrefix = $fieldSuffix = $suffix = '';

    if ($form['#type'] == "inline_entity_form") {
      $fieldPrefix = self::generateParentsField($form);
      $suffix = ']';
    }

    foreach ($states as $state) {
      /** @var $state \Drupal\state\Entity\State */
      if (!isset($form[$state->getFieldTarget()]) && !isset($form[$state->getFieldToggle()])) {
        continue;
      }

      $entityType = \Drupal::entityTypeManager()->getDefinition($state->getFormFieldParent());
      $test = $entityType->get($state->getFieldToggle());

      if (isset($form[$state->getFieldToggle()]['value'])) {
        $fieldSuffix = '[value]';
      }
      $form = self::generateStatesVisibleElements($form, $state->getFieldTarget(), $state->getStatesType(), $fieldPrefix, $state->getFieldToggle(), $fieldSuffix, $state->getValueNested());
    }

    return $form;
  }

  /**
   * Handle element state.
   *
   * @param array $form
   *   The form wrapper elements.
   * @param string $delta
   *   The field name.
   * @param string $state
   *   The behavior required.
   * @param string $fieldPrefix
   *   The potential prefix for field.
   * @param string $field
   *   The field name.
   * @param string $fieldSuffix
   *   The potential suffix for field.
   * @param string $behavior
   *   The behavior value.
   *
   * @return mixed
   *   The state created and returned.
   */
  protected static function generateStatesVisibleElements(array $form, $fieldTarget, $stateType, $fieldPrefix, $fieldToggle, $fieldSuffix, $value) {

    $x=0;
    $fieldsTypes = ['checkbox', 'checkboxes'];
    $neested = 'value';
    if (in_array($form[$fieldToggle]['widget']['#type'], $fieldsTypes)) {
      $neested = 'checked';
    }


    $form[$fieldTarget]['#states'][$stateType] = [
      ':input[name="' . $fieldPrefix . '' . $fieldToggle . '' . $fieldSuffix . '"]' => [$neested => $value],
    ];

    return $form;
  }

  /**
   * Handle ajax element.
   *
   * @param array $form
   *   The form wrapper elements.
   * @param string $field
   *   The field name.
   * @param string $state
   *   The behavior required.
   * @param array $callback
   *   The callback need to get value, and event js.
   *
   * @return mixed
   *   The ajax event created and returned.
   */
  protected static function generateStatesAjaxElements(array $form, $field, $state, array $callback) {
    $form[$field]['widget']['#' . $state] = $callback;

    return $form;
  }

  /**
   * Method handle recusrivity.
   *
   * @param array $form
   *   The form.
   *
   * @return mixed
   *   The field target.
   */
  protected static function generateParentsField(array $form) {
    $fieldPrefix = $form['#parents'][0];

    foreach ($form['#parents'] as $key => $parent) {
      if ($key != 0) {
        $fieldPrefix .= '[' . $parent . ']';
      }
    }
    $fieldPrefix .= '[';

    return $fieldPrefix;
  }

}
