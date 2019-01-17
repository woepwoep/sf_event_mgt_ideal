<?php
return [
    'ctrl' => [
        'title'	=> 'LLL:EXT:sf_event_mgt_ideal/Resources/Private/Language/locallang_db.xlf:tx_sfeventmgtideal_domain_model_idealtransaction',
        'label' => 'issuer_id',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
		'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
		'searchFields' => 'merchant_id,issuer_id,amount,currency,expirationperiod,language,description,entrancecode,purchase_id,tx_id,acquirer_id,tx_status,tx_status_timestamp,tx_consumer_name,tx_consumer_iban,tx_consumer_bic,registration',
        'iconfile' => 'EXT:sf_event_mgt_ideal/Resources/Public/Icons/tx_sfeventmgtideal_domain_model_idealtransaction.gif'
    ],
    'interface' => [
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, merchant_id, issuer_id, amount, currency, expirationperiod, language, description, entrancecode, purchase_id, tx_id, acquirer_id, tx_status, tx_status_timestamp, tx_consumer_name, tx_consumer_iban, tx_consumer_bic, registration',
    ],
    'types' => [
		'1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, merchant_id, issuer_id, amount, currency, expirationperiod, language, description, entrancecode, purchase_id, tx_id, acquirer_id, tx_status, tx_status_timestamp, tx_consumer_name, tx_consumer_iban, tx_consumer_bic, registration, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
    ],
    'columns' => [
		'sys_language_uid' => [
			'exclude' => true,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'special' => 'languages',
				'items' => [
					[
						'LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages',
						-1,
						'flags-multiple'
					]
				],
				'default' => 0,
			],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_sfeventmgtideal_domain_model_idealtransaction',
                'foreign_table_where' => 'AND tx_sfeventmgtideal_domain_model_idealtransaction.pid=###CURRENT_PID### AND tx_sfeventmgtideal_domain_model_idealtransaction.sys_language_uid IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
		't3ver_label' => [
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            ],
        ],
		'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
                'items' => [
                    '1' => [
                        '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
                    ]
                ],
            ],
        ],
		'starttime' => [
            'exclude' => true,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'size' => 13,
                'eval' => 'datetime',
                'default' => 0,
            ]
        ],
        'endtime' => [
            'exclude' => true,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'size' => 13,
                'eval' => 'datetime',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038)
                ]
            ],
        ],
	    'merchant_id' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:sf_event_mgt_ideal/Resources/Private/Language/locallang_db.xlf:tx_sfeventmgtideal_domain_model_idealtransaction.merchant_id',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
        'issuer_id' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:sf_event_mgt_ideal/Resources/Private/Language/locallang_db.xlf:tx_sfeventmgtideal_domain_model_idealtransaction.issuer_id',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'amount' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:sf_event_mgt_ideal/Resources/Private/Language/locallang_db.xlf:tx_sfeventmgtideal_domain_model_idealtransaction.amount',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'double2'
			]
	    ],
        'currency' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:sf_event_mgt_ideal/Resources/Private/Language/locallang_db.xlf:tx_sfeventmgtideal_domain_model_idealtransaction.currency',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
        'expirationperiod' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:sf_event_mgt_ideal/Resources/Private/Language/locallang_db.xlf:tx_sfeventmgtideal_domain_model_idealtransaction.expirationperiod',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
        'language' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:sf_event_mgt_ideal/Resources/Private/Language/locallang_db.xlf:tx_sfeventmgtideal_domain_model_idealtransaction.language',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'description' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:sf_event_mgt_ideal/Resources/Private/Language/locallang_db.xlf:tx_sfeventmgtideal_domain_model_idealtransaction.description',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'entrancecode' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:sf_event_mgt_ideal/Resources/Private/Language/locallang_db.xlf:tx_sfeventmgtideal_domain_model_idealtransaction.entrancecode',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'purchase_id' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:sf_event_mgt_ideal/Resources/Private/Language/locallang_db.xlf:tx_sfeventmgtideal_domain_model_idealtransaction.purchase_id',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'tx_id' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:sf_event_mgt_ideal/Resources/Private/Language/locallang_db.xlf:tx_sfeventmgtideal_domain_model_idealtransaction.tx_id',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
        'acquirer_id' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:sf_event_mgt_ideal/Resources/Private/Language/locallang_db.xlf:tx_sfeventmgtideal_domain_model_idealtransaction.acquirer_id',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'tx_status' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:sf_event_mgt_ideal/Resources/Private/Language/locallang_db.xlf:tx_sfeventmgtideal_domain_model_idealtransaction.tx_status',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'tx_status_timestamp' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:sf_event_mgt_ideal/Resources/Private/Language/locallang_db.xlf:tx_sfeventmgtideal_domain_model_idealtransaction.tx_status_timestamp',
	        'config' => [
			    'dbType' => 'datetime',
			    'type' => 'input',
			    'size' => 12,
			    'eval' => 'datetime',
			    'default' => '0000-00-00 00:00:00'
			],
	    ],
	    'tx_consumer_name' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:sf_event_mgt_ideal/Resources/Private/Language/locallang_db.xlf:tx_sfeventmgtideal_domain_model_idealtransaction.tx_consumer_name',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'tx_consumer_iban' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:sf_event_mgt_ideal/Resources/Private/Language/locallang_db.xlf:tx_sfeventmgtideal_domain_model_idealtransaction.tx_consumer_iban',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'tx_consumer_bic' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:sf_event_mgt_ideal/Resources/Private/Language/locallang_db.xlf:tx_sfeventmgtideal_domain_model_idealtransaction.tx_consumer_bic',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'registration' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:sf_event_mgt_ideal/Resources/Private/Language/locallang_db.xlf:tx_sfeventmgtideal_domain_model_idealtransaction.registration',
	        'config' => [
			    'type' => 'select',
			    'renderType' => 'selectSingle',
			    'foreign_table' => 'tx_sfeventmgt_domain_model_registration',
			    'minitems' => 0,
			    'maxitems' => 1,
			],
	    ],
    ],
];
