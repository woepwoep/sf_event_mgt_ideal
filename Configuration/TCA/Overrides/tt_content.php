<?php
/**
 * Include FlexForm of plugin Itx of extension EXT:sf_event_mgt_ideal
 */
$pluginSignature = 'sfeventmgtideal_itx';

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
	$pluginSignature,
	'FILE:EXT:sf_event_mgt_ideal/Configuration/FlexForms/Flexform_plugin_itx.xml'
);
