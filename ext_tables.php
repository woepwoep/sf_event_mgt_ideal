<?php
defined('TYPO3_MODE') || die('Access denied.');

// register plugin
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'RedSeadog.SfEventMgtIdeal',
	'Itx',
	'sf_event_mgt_ideal - payment processing'
);

// add static file
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'sf_event_mgt_ideal');

// new table idealtransaction -- to store transaction request AND transaction status
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_sfeventmgtideal_domain_model_idealtransaction', 'EXT:sf_event_mgt_ideal/Resources/Private/Language/locallang_csh_tx_sfeventmgtideal_domain_model_idealtransaction.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_sfeventmgtideal_domain_model_idealtransaction');


/**
 * Include FlexForm of plugin Itx of extension EXT:sf_event_mgt_ideal
 */
$extensionName = strtolower(\TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase('sf_event_mgt_ideal'));
$pluginName = strtolower('Itx');
$pluginSignature = $extensionName.'_'.$pluginName;

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,select_key';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/Flexform_plugin_itx.xml');
