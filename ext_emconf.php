<?php

/***************************************************************
 * Extension Manager/Repository config file for ext: "sf_event_mgt_ideal"
 *
 * Auto generated by Extension Builder 2017-04-17
 *
 * Manual updates:
 * Only the data in the array - anything else is removed by next write.
 * "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = [
    'title' => 'sf_event_mgt_ideal',
    'description' => 'Payment extension for sf_event_mgt',
    'category' => 'plugin',
    'author' => 'Ronald Wopereis',
    'author_email' => 'woepwoep@gmail.com',
    'state' => 'stable',
    'internal' => '',
    'uploadfolder' => '0',
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'version' => '2.01.17',
    'constraints' => [
        'depends' => [
            'typo3' => '7.6.0-8.99.99',
			'sf_event_mgt' => '1.8.0-3.99.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
