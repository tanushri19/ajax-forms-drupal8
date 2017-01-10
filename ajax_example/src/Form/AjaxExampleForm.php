<?php
/**
 * @file
 * Contains Drupal\ajax_example\AjaxExampleForm
 */

namespace Drupal\ajax_example\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;

class AjaxExampleForm extends FormBase {

  public function getFormId() {
    return 'ajax_example_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['user_email'] = array(
      '#type' => 'textfield',
      '#title' => 'Username or Email',
      '#description' => 'Please enter in a username or Email',
      '#prefix' => '<div id="user-email-result"></div>',
      '#ajax' => array(
        'callback' => '::checkUserEmailValidation',
        'effect' => 'fade',
        'event' => 'change',
        'progress' => array(
          'type' => 'throbber',
          'message' => NULL,
        ),
      ),
    );
    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    //nothing to do here
  }

  public function checkUserEmailValidation(array $form, FormStateInterface $form_state) {
    $ajax_response = new AjaxResponse();
    if (user_load_by_name($form_state->getValue('user_email')) || user_load_by_mail($form_state->getValue('user_email'))) {
      $text = 'User or Email is exists';
    } else {
      $text = 'User or Email does not exists';
    }
    $ajax_response->addCommand(new HtmlCommand('#user-email-result', $text));
    return $ajax_response;
  }

}




