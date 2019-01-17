<?php
namespace RedSeadog\SfEventMgtIdeal\Payment;

use \RedSeadog\SfEventMgtIdeal\Service\Configuration\DefaultConfiguration;
use \RedSeadog\SfEventMgtIdeal\Service\Log\DefaultLog;
use \RedSeadog\SfEventMgtIdeal\Service\Entities\Transaction;
use \RedSeadog\SfEventMgtIdeal\Service\IdealService;
use \RedSeadog\SfEventMgtIdeal\Service\PluginService;

use \TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use \TYPO3\CMS\Core\Utility\DebugUtility;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * IdealPayment
 *
 * @author Ronald Wopereis <woepwoep@gmail.com>
 */
class IdealPayment extends \DERHANSEN\SfEventMgt\Payment\AbstractPayment
{

    /**
     * Enable redirect for payment method
     *
     * @var bool
     */
    protected $enableRedirect = true;

    /**
     * Enable success link for payment method
     *
     * @var bool
     */
    protected $enableSuccessLink = true;

    /**
     * Enable failure link for payment method
     *
     * @var bool
     */
    protected $enableFailureLink = true;

    /**
     * Enable cancel link for payment method
     *
     * @var bool
     */
    protected $enableCancelLink = true;

    /**
     * Enable notify link for payment method
     *
     * @var bool
     */
    protected $enableNotifyLink = true;


	//
	protected $config;
	protected $idealService;
	protected $pluginService;


	//
	protected $objectManager;

	public function __construct()
	{
		$this->objectManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
		$this->pluginService = new PluginService('tx_sfeventmgtideal');

		$idealConfigurationFile = $this->pluginService->getIdealConfigurationFile();
        $this->config = new DefaultConfiguration($idealConfigurationFile);

		// overrule $this->config with pluginsettings
		$this->config->setMerchantReturnUrl($this->pluginService->getMerchantReturnUrl());

		/** @var \RedSeadog\SfEventMgtIdeal\Service\Log\DefaultLog $log */
		$log = new DefaultLog($this->config->getLogLevel(),$this->config->getLogFile());
		/** @param \RedSeadog\SfEventMgtIdeal\Service\IdealService $idealService */
		$this->idealService = new IdealService($this->config, $log);
	}


	/**
	 * Adds required HTML (for redirection) to the given values-array
	 *
	 * @param array $values
	 * @param bool $updateRegistration
	 * @param \DERHANSEN\SfEventMgt\Domain\Model\Registration $registration
	 * @param ActionController $pObj
	 * @return void
	 */
	public function renderRedirectView(&$values, &$updateRegistration, $registration, $pObj)
	{
		/** @var \TYPO3\CMS\Fluid\View\StandaloneView $view */ 
		$view = $this->objectManager->get('TYPO3\\CMS\\Fluid\\View\\StandaloneView');
		$view->setFormat('html');

		$templateName = $this->pluginService->getPaymentForm();	// constants.txt :: 'paymentForm'
		$controller = 'Payment';
		$view->setTemplatePathAndFilename($this->pluginService->getTemplatePathAndFilename($controller,$templateName));

		// create IdealTransaction object
		$idealTransaction = $this->objectManager->get('RedSeadog\\SfEventMgtIdeal\\Domain\\Model\\IdealTransaction');
		// Issuer: id
		/*
		 * issuerId is not yet known. we have to ask the customer. we do this by adding a fluid variable 'directoryResponse' see below
		 */
		// Merchant: id, subid, returnurl
		$idealTransaction->setMerchantId($this->config->getMerchantId());
		$idealTransaction->setMerchantSubId($this->config->getSubId());
		$idealTransaction->setMerchantReturnUrl($this->config->getMerchantReturnURL());
		// Transaction: purchaseid, amount, currency, expirationperiod, language, description, entrancecode
		$idealTransaction->setPurchaseId(strval($registration->getUid()));
		$idealTransaction->setAmount($registration->getPaymentPrice());
		$idealTransaction->setCurrency('EUR');
		$idealTransaction->setExpirationPeriod($this->config->getExpirationPeriod());
		$idealTransaction->setLanguage('nl');
		$idealTransaction->setDescription($registration->getEvent()->getTitle());
		$idealTransaction->setEntranceCode('1234567890123456789012345678901234567890');
		$idealTransaction->setRegistration($registration);

		//
		$view->assign('settings',$this->pluginService->getSettings());
		$view->assign('directoryResponse',$this->idealService->getIssuers());
		$view->assign('idealTransaction',$idealTransaction);

		//
		$values['html'] = $view->render();

	}
}
