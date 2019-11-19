<?php
define('GIFT_CARD_REFEREE', 345);
define('GIFT_CARD_TOTAL', 346);
define('GIFT_CARD_AMOUNT', 347);
define('GIFT_CARD_NAME', 349);

require_once 'multiplehonorees.civix.php';
use CRM_Multiplehonorees_ExtensionUtil as E;

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function multiplehonorees_civicrm_config(&$config) {
  _multiplehonorees_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function multiplehonorees_civicrm_xmlMenu(&$files) {
  _multiplehonorees_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function multiplehonorees_civicrm_install() {
  _multiplehonorees_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_postInstall
 */
function multiplehonorees_civicrm_postInstall() {
  _multiplehonorees_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function multiplehonorees_civicrm_uninstall() {
  _multiplehonorees_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function multiplehonorees_civicrm_enable() {
  _multiplehonorees_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function multiplehonorees_civicrm_disable() {
  _multiplehonorees_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function multiplehonorees_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _multiplehonorees_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function multiplehonorees_civicrm_managed(&$entities) {
  _multiplehonorees_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function multiplehonorees_civicrm_caseTypes(&$caseTypes) {
  _multiplehonorees_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_angularModules
 */
function multiplehonorees_civicrm_angularModules(&$angularModules) {
  _multiplehonorees_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function multiplehonorees_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _multiplehonorees_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_entityTypes
 */
function multiplehonorees_civicrm_entityTypes(&$entityTypes) {
  _multiplehonorees_civix_civicrm_entityTypes($entityTypes);
}

function multiplehonorees_civicrm_buildForm($formName, &$form) {
  if ($formName == "CRM_Contribute_Form_Contribution_Main") {
    $isActive = FALSE;
    if ($id = $form->getVar('_id')) {
      $isActive = CRM_Utils_Array::value('multiple_honor_section_active', _getSetting($id), FALSE);
    }
    if ($isActive) {
      CRM_Core_Region::instance('page-body')->add(array(
        'template' => 'multiplehonorees.tpl',
      ));
      $form->add('text', 'referred_by', ts('Referred by'), NULL);
      $form->add('text', 'total_card', ts('Number of cards requested'), NULL);
      $form->add('text', 'each_gift_amount', ts('Donation amount per card'), NULL);
      $fields = [
        'honoree_name' => ts('Honoree Name'),
        'gift_amount' => ts('Amount')
      ];
      for ($rowNumber = 1; $rowNumber <= 25; $rowNumber++) {
        foreach ($fields as $fieldName => $fieldLabel) {
          $name = sprintf("%s[%d]", $fieldName, $rowNumber);
          $form->add('text', $name, $fieldLabel, NULL);
        }
      }
    }
  }
  elseif ($formName == 'CRM_Contribute_Form_ContributionPage_Settings') {
    $form->addElement('checkbox', 'multiple_honor_section_active', ts('Multiple Honoree Section Enabled'));
    CRM_Core_Region::instance('page-body')->add(array(
      'template' => 'multiplehonoreesetting.tpl',
    ));
    if ($id = $form->getVar('_id')) {
      $form->setDefaults(_getSetting($id));
    }
  }
}

function _getSetting($id) {
  $moduleData = [];
  $ufJoinDAO = new CRM_Core_DAO_UFJoin();
  $ufJoinDAO->module = 'multiple_honoree';
  $ufJoinDAO->entity_id = $id;
  $ufJoinDAO->find(TRUE);

  if (!empty($ufJoinDAO->id)) {
    $moduleData = json_decode($ufJoinDAO->module_data, TRUE);
  }

  return $moduleData;
}

function multiplehonorees_civicrm_postProcess($formName, &$form) {
  if ($formName == 'CRM_Contribute_Form_ContributionPage_Settings') {
    $id = $form->getVar('_id') ?: $form->get('id');
    $isActive = CRM_Utils_Array::value('multiple_honor_section_active', $form->_submitValues, FALSE);
    if (!empty($id)) {
      $ufJoinDAO = new CRM_Core_DAO_UFJoin();
      $ufJoinDAO->module = 'multiple_honoree';
      $ufJoinDAO->entity_id = $id;
      $ufJoinDAO->find(TRUE);

      $ufJoinParams = [
        'id' => $ufJoinDAO->id,
        'uf_group_id' => 13,
        'is_active' => 1,
        'module' => 'multiple_honoree',
        'entity_table' => 'civicrm_contribution_page',
        'entity_id' => $id,
        'module_data' => json_encode(['multiple_honor_section_active' => $isActive]),
      ];
      CRM_Core_BAO_UFJoin::create($ufJoinParams);
    }
  }
  elseif ($formName == 'CRM_Contribute_Form_Contribution_Confirm') {
    $params = $form->getVar('_params');
    if (!empty($params['contributionID'])) {
      $honorNames = [];
      if (!empty($params['gift_amount'])) {
         $contributionID = $params['contributionID'];
         $sql = "INSERT INTO civicrm_entity_multiple_honoree(`contribution_id`, `honoree_name`, `amount`) VALUES ";
         $entries = [];
         foreach ($params['gift_amount'] as $id => $value) {
           if (!empty($value)) {
             $name = CRM_Utils_Array::value($id, $params['honoree_name']);
             $entries[] = sprintf("(%d, '%s', %s)", $contributionID, $name, $value);
             if (!empty($name)) {
               if ($value != $params['each_gift_amount']) {
                 $honorNames[] = sprintf("%s ($ %05.2f)", $name, $value);
               }
               else {
                 $honorNames[] = $name;
               }
             }
           }
        }
        if (!empty($entries)) {
            $sql .= implode(", ", $entries) . ";";
            CRM_Core_DAO::executeQuery($sql);
        }
      }

      // populate api params
      $fields = [
        'referred_by' => 'custom_' . GIFT_CARD_REFEREE,
        'total_card' => 'custom_' . GIFT_CARD_TOTAL,
        'each_gift_amount' => 'custom_' . GIFT_CARD_AMOUNT,
        'honoree_names' => 'custom_' . GIFT_CARD_NAME,
      ];
      $apiparams = [];
      foreach ($fields as $key => $customFieldKey) {
        if ($key == 'honoree_names' && !empty($honorNames)) {
          $apiparams[$customFieldKey] = implode(", ", $honorNames);
        }
        elseif (!empty($params[$key])) {
          $apiparams[$customFieldKey] = $params[$key];
        }
      }
      if (!empty($apiparams)) {
        civicrm_api3('Contribution', 'create', array_merge([
          'id' => $params['contributionID'],
        ], $apiparams));
      }
    }
  }
}



// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 *
function multiplehonorees_civicrm_preProcess($formName, &$form) {

} // */

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_navigationMenu
 *
function multiplehonorees_civicrm_navigationMenu(&$menu) {
  _multiplehonorees_civix_insert_navigation_menu($menu, 'Mailings', array(
    'label' => E::ts('New subliminal message'),
    'name' => 'mailing_subliminal_message',
    'url' => 'civicrm/mailing/subliminal',
    'permission' => 'access CiviMail',
    'operator' => 'OR',
    'separator' => 0,
  ));
  _multiplehonorees_civix_navigationMenu($menu);
} // */
