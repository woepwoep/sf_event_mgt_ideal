<?php
namespace RedSeadog\SfEventMgtIdeal\Domain\Model;

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

/**
 * IdealTransaction
 */
class IdealTransaction extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /** @var string */
    protected $merchantId = '';

    /** @var string */
    protected $merchantSubId = '';

    /** @var string */
    protected $merchantReturnUrl = '';

    /** @var string */
    protected $issuerId = '';

    /** @var float */
    protected $amount = 0.0;

    /** @var string */
    protected $currency = 'EUR';

    /** @var string */
    protected $expirationPeriod = '';

    /** @var string */
    protected $language = 'nl';

    /** @var string */
    protected $description = '';

    /** @var string */
    protected $entrancecode = '';

    /** @var string */
    protected $purchaseId = '';

    /** @var string */
    protected $txId = '';

    /** @var string */
    protected $acquirerId = '';

    /** @var string */
    protected $txStatus = '';

    /** @var DateTime */
    protected $txStatusTimestamp = null;

    /** @var string */
    protected $txConsumerName = '';

    /** @var string */
    protected $txConsumerIban = '';

    /** @var string */
    protected $txConsumerBic = '';

    /** @var \DERHANSEN\SfEventMgt\Domain\Model\Registration */
    protected $registration = null;


    /** @return string $merchantId */
    public function getMerchantId()
    {
        return $this->merchantId;
    }

    /**
     * @param string $merchantId
     * @return void
     */
    public function setMerchantId($merchantId)
    {
        $this->merchantId = $merchantId;
    }

    /** @return string $merchantSubId */
    public function getMerchantSubId()
    {
        return $this->merchantSubId;
    }

    /**
     * @param string $merchantSubId
     * @return void
     */
    public function setMerchantSubId($merchantSubId)
    {
        $this->merchantSubId = $merchantSubId;
    }

    /** @return string $merchantReturnUrl */
    public function getMerchantReturnUrl()
    {
        return $this->merchantReturnUrl;
    }

    /**
     * @param string $merchantReturnUrl
     * @return void
     */
    public function setMerchantReturnUrl($merchantReturnUrl)
    {
        $this->merchantReturnUrl = $merchantReturnUrl;
    }

    /** @return string $issuerId */
    public function getIssuerId()
    {
        return $this->issuerId;
    }

    /**
     * @param string $issuerId
     * @return void
     */
    public function setIssuerId($issuerId)
    {
        $this->issuerId = $issuerId;
    }

    /** @return float $amount */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Sets the amount
     *
     * @param float $amount
     * @return void
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /** @return string $currency */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     * @return void
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    /** @return string $expirationPeriod */
    public function getExpirationPeriod()
    {
        return $this->expirationPeriod;
    }

    /**
     * @param string $expirationPeriod
     * @return void
     */
    public function setExpirationPeriod($expirationPeriod)
    {
        $this->expirationPeriod = $expirationPeriod;
    }

    /** @return string $language */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param string $language
     * @return void
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }

    /** @return string $description */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /** @return string $entrancecode */
    public function getEntrancecode()
    {
        return $this->entrancecode;
    }

    /**
     * @param string $entrancecode
     * @return void
     */
    public function setEntrancecode($entrancecode)
    {
        $this->entrancecode = $entrancecode;
    }

    /** @return string $purchaseId */
    public function getPurchaseId()
    {
        return $this->purchaseId;
    }

    /**
     * @param string $purchaseId
     * @return void
     */
    public function setPurchaseId($purchaseId)
    {
        $this->purchaseId = $purchaseId;
    }

    /** @return string $txId */
    public function getTxId()
    {
        return $this->txId;
    }

    /**
     * @param string $txId
     * @return void
     */
    public function setTxId($txId)
    {
        $this->txId = $txId;
    }

    /** @return string $acquirerId */
    public function getAcquirerId()
    {
        return $this->acquirerId;
    }

    /**
     * @param string $acquirerId
     * @return void
     */
    public function setAcquirerId($acquirerId)
    {
        $this->acquirerId = $acquirerId;
    }

    /** @return string $txStatus */
    public function getTxStatus()
    {
        return $this->txStatus;
    }

    /**
     * @param string $txStatus
     * @return void
     */
    public function setTxStatus($txStatus)
    {
        $this->txStatus = $txStatus;
    }

    /** @return \DateTime $txStatusTimestamp */
    public function getTxStatusTimestamp()
    {
        return $this->txStatusTimestamp;
    }

    /**
     * @param \DateTime $txStatusTimestamp
     * @return void
     */
    public function setTxStatusTimestamp(\DateTime $txStatusTimestamp)
    {
        $this->txStatusTimestamp = $txStatusTimestamp;
    }

    /** @return string $txConsumerName */
    public function getTxConsumerName()
    {
        return $this->txConsumerName;
    }

    /**
     * @param string $txConsumerName
     * @return void
     */
    public function setTxConsumerName($txConsumerName)
    {
        $this->txConsumerName = $txConsumerName;
    }

    /** @return string $txConsumerIban */
    public function getTxConsumerIban()
    {
        return $this->txConsumerIban;
    }

    /**
     * @param string $txConsumerIban
     * @return void
     */
    public function setTxConsumerIban($txConsumerIban)
    {
        $this->txConsumerIban = $txConsumerIban;
    }

    /** @return string $txConsumerBic */
    public function getTxConsumerBic()
    {
        return $this->txConsumerBic;
    }

    /**
     * @param string $txConsumerBic
     * @return void
     */
    public function setTxConsumerBic($txConsumerBic)
    {
        $this->txConsumerBic = $txConsumerBic;
    }

    /** @return \DERHANSEN\SfEventMgt\Domain\Model\Registration $registration */
    public function getRegistration()
    {
        return $this->registration;
    }

    /**
     * @param \DERHANSEN\SfEventMgt\Domain\Model\Registration $registration
     * @return void
     */
    public function setRegistration(\DERHANSEN\SfEventMgt\Domain\Model\Registration $registration)
    {
        $this->registration = $registration;
    }
}
