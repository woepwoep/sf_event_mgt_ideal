<?php
namespace RedSeadog\SfEventMgtIdeal\Controller;

/***
 *
 * This file is part of the "sf_event_mgt_ideal" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2017 Ronald Wopereis <woepwoep@gmail.com>, Red-Seadog
 *
 ***/

use \RedSeadog\SfEventMgtIdeal\Domain\Model\IdealTransaction;
use \RedSeadog\SfEventMgtIdeal\Domain\Repository\IdealTransactionRepository;

use \RedSeadog\SfEventMgtIdeal\Service\IdealService;
use \RedSeadog\SfEventMgtIdeal\Service\PluginService;

use \RedSeadog\SfEventMgtIdeal\Service\Configuration\DefaultConfiguration;
use \RedSeadog\SfEventMgtIdeal\Service\Entities\Transaction;
use \RedSeadog\SfEventMgtIdeal\Service\Log\DefaultLog;

use \TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * IdealTransactionController
 */
class IdealTransactionController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
	/**
	 * @var \RedSeadog\SfEventMgtIdeal\Domain\Repository\IdealTransactionRepository
	 */
	protected $idealTransactionRepository = null;

	/**
	 * @var IdealService $idealService
	 */
	protected $idealService = null;

	/**
	 * @var DefaultConfiguration
	 */
	protected $config;

	/**
	 * @var \RedSeadog\SfEventMgtIdeal\Service\PluginService
	 */
	protected $pluginSettings;

    /**
     * Notification Service
     *
     * @var \DERHANSEN\SfEventMgt\Service\NotificationService
     * @inject
     */
    protected $notificationService = null;

    /**
     * RegistrationService
     *
     * @var \DERHANSEN\SfEventMgt\Service\RegistrationService
     * @inject
     */
    protected $registrationService = null;

    /**
     * Hash Service
     *
     * @var \TYPO3\CMS\Extbase\Security\Cryptography\HashService
     * @inject
     */
    protected $hashService;


	public function injectIdealTransactionRepository(IdealTransactionRepository $idealTransactionRepository)
	{
		$this->idealTransactionRepository = $idealTransactionRepository;
	}

	public function __construct()
	{
		$this->pluginSettings = new PluginService('tx_sfeventmgtideal');
		$idealConfigurationFile = $this->pluginSettings->getIdealConfigurationFile();
		$this->config = new DefaultConfiguration($idealConfigurationFile);
		$log = new DefaultLog($this->config->getLogLevel(),$this->config->getLogFile());
		$this->idealService = new IdealService($this->config,$log);
	}

	/**
	 * addAction -- is called from Templates/Payment/AddForm.html
	 *		(1) register transaction details with issuer
	 *		(2) retrieve from issuer a txid and an issuerAuthenticationURL
	 *		(3) adds an IdealTransaction with ref to Registration, then redirects to issuerAuthenticationURL
	 *
	 * @param \RedSeadog\SfEventMgtIdeal\Domain\Model\IdealTransaction $idealTransaction
	 * @return void
	 */
	public function addAction(\RedSeadog\SfEventMgtIdeal\Domain\Model\IdealTransaction $idealTransaction)
	{
		// prepare transaction request
		$issuerId = $idealTransaction->getIssuerId();
		$purchaseId = $idealTransaction->getPurchaseId();
		$amount = $idealTransaction->getAmount();
		$currency = $idealTransaction->getCurrency();	// must be 'EUR'
		$expirationPeriod = $idealTransaction->getExpirationPeriod();
		$language = $idealTransaction->getLanguage();	// must be 'nl'
		$description = substr($idealTransaction->getDescription(),0,35);
		$entranceCode = $idealTransaction->getEntranceCode();
		$merchantReturnUrl = $idealTransaction->getMerchantReturnUrl();

		// these values all in one iDEAL Entity object $tx
		/** @var Transaction $tx */
		$tx = new Transaction($amount,$description,$entranceCode,(int)$expirationPeriod,$purchaseId,$currency,$language);

		// reach out for the bank (issuer)
		$acquirerTransactionResponse = $this->idealService->startTransaction($issuerId,$tx,$merchantReturnUrl);

		// response from Issuer
		$trxId = $acquirerTransactionResponse->getTransactionId();
		$issuerAuthenticationURL = $acquirerTransactionResponse->getIssuerAuthenticationURL();
		$acquirerID = $acquirerTransactionResponse->getAcquirerID();

		// add info to object
		$idealTransaction->setTxId($trxId);
		$idealTransaction->setAcquirerId($acquirerId);

		// persist object
		$this->idealTransactionRepository->add($idealTransaction);
		$persistenceManager = $this->objectManager->get("TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager");
		$persistenceManager->persistAll();

		// present customer bank dialogue url
		\TYPO3\CMS\Core\Utility\HttpUtility::redirect($issuerAuthenticationURL);
	}

	/**
	 * updateStatusAction -- this is the MerchantReturnURL action
	 *		(1) retrieve the _GP['txid'] from the MerchantReturnURL
	 *		(2) findsbyTxId the IdealTransaction repository
	 *		(3) retrieves the transaction status from the acquirer
	 *		(4) updates the repository with the values found in the transaction status response
	 *		(5) show the result in Templates/IdealTransaction/UpdateStatus.html
	 *
	 * @return void
	 */
	public function updateStatusAction()
	{
		// (1)
		$trxid = GeneralUtility::_GP('trxid');
		$entranceCode = GeneralUtility::_GP('ec');

		// (2)
		/** @var IdealTransaction $idealTransaction */
		$idealTransaction = $this->idealTransactionRepository->findByTxId($trxid)->getFirst();
		if (empty($idealTransaction)) {
			debug('Transaction '.$trxid.' not found in IdealTransactionRepository.');
			exit(1);
		}

		// (3)
		$response = $this->idealService->getTransactionStatus($trxid);
		
		// (4)
		$idealTransaction->setAcquirerId($response->getAcquirerId());
		$idealTransaction->setTxStatus($response->getStatus());
		$idealTransaction->setTxStatusTimestamp($response->getStatusTimestamp());
		$idealTransaction->setTxConsumerName($response->getConsumerName());
		$idealTransaction->setTxConsumerIban($response->getConsumerIban());
		$idealTransaction->setTxConsumerBic($response->getConsumerBic());
		$idealTransaction->setAmount($response->getAmount());
		$idealTransaction->setCurrency($response->getCurrency());

		// update registration because we have no way of transferring $trxid
		$idealTransaction->getRegistration()->setPaymentReference($trxid);

		// update and persistAll
		$this->idealTransactionRepository->update($idealTransaction);
		$persistenceManager = $this->objectManager->get("TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager");
		$persistenceManager->persistAll();

		// redirect naar Pipayment::successAction / cancelAction / failureAction - depending on $response.status
		switch($response->getStatus()) {
		default:	// fall through
			$actionName = 'failure';
			break;
		case 'Success':
			$actionName = 'success';
			break;
		case 'Cancelled':
			$actionName = 'cancel';
			break;
		}
		$registration = $idealTransaction->getRegistration();
        $paymentReturnPid = $this->pluginSettings->getPaymentReturnPid();
		$this->uriBuilder->reset()
			->setTargetPageUid($paymentReturnPid)
			->setUseCacheHash(false);
		$uri =  $this->uriBuilder->uriFor(
			$actionName,
			[
				'registration' => $registration,
				'hmac' => $this->hashService->generateHmac($actionName.'Action-' . $registration->getUid())
			],
			'Payment',
			'sfeventmgt',
			'Pipayment'
		);
		$this->redirectToUri($uri);

		// (5)
		$this->view->assign('idealTransaction',$idealTransaction);
	}

	/**
	 * @param string $trxid
	 * @return void
	 */
	public function factuurAction($trxid)
	{
		$idealTransaction = $this->idealTransactionRepository->findByTxId($trxid)->getFirst();
		if (empty($idealTransaction)) {
			debug('Transaction '.$trxid.' not found in IdealTransactionRepository.');
			exit(1);
		}
		$this->view->assign('idealTransaction',$idealTransaction);
	}
}
