<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

// Configure plugin
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'RedSeadog.SfEventMgtIdeal',
	'Itx',
	[
		'IdealTransaction' => 'updateStatus,update,add,factuur'
	],
	// non-cacheable actions
	[
		'IdealTransaction' => 'updateStatus,update,add,factuur'
	]
);

// Register payment provider
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['sf_event_mgt']['paymentMethods']['ideal'] = [
	'class' => 'RedSeadog\\SfEventMgtIdeal\\Payment\\IdealPayment',
	'extkey' => 'sf_event_mgt_ideal'
];

/** @var \TYPO3\CMS\Extbase\SignalSlot\Dispatcher $signalSlotDispatcher */
$signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\SignalSlot\\Dispatcher');
$signalSlotDispatcher->connect(
	'DERHANSEN\\SfEventMgt\\Controller\\PaymentController',
	'redirectActionBeforeRedirectIdeal',
	'RedSeadog\\SfEventMgtIdeal\\Payment\\IdealPayment',
	'renderRedirectView',
	false
);
