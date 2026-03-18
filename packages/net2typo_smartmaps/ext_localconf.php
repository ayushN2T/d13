<?php
defined('TYPO3') || die();

(static function() {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Smartmaps',
        'Smartmap',
        [
            \NET2TYPO\Smartmaps\Controller\MapController::class => 'showMap'
        ],
        // non-cacheable actions
        [
            \NET2TYPO\Smartmaps\Controller\MapController::class => 'showMap'
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Smartmaps',
        'Fetchcordinates',
        [
            \NET2TYPO\Smartmaps\Controller\MapController::class => 'fetch',
        ],
        [
            \NET2TYPO\Smartmaps\Controller\MapController::class => 'fetch'
        ],
    );

    // wizards
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        'mod {
            wizards.newContentElement.wizardItems.plugins {
                elements {
                    smartmap {
                        iconIdentifier = smartmaps-plugin-smartmap
                        title = LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_smartmap.name
                        description = LLL:EXT:smartmaps/Resources/Private/Language/locallang_db.xlf:tx_smartmaps_smartmap.description
                        tt_content_defValues {
                            CType = list
                            list_type = smartmaps_smartmap
                        }
                    }
                }
                show = *
            }
       }'
    );

    // add costum backend form elements
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][1580467607] = [
        'nodeName' => 'SmartMapGeocodeElement',
        'priority' => 40,
        'class' => \NET2TYPO\Smartmaps\Form\Element\SmartMapGeocodeElement::class
    ];
})();
