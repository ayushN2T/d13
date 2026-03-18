<?php
defined('TYPO3') || die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'Smartmaps',
    'Smartmap',
    'Smartmaps'
);

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['smartmaps_smartmap'] = 'recursive,select_key,pages';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    '*',
    'FILE:EXT:smartmaps/Configuration/FlexForms/flexform_smartmaps.xml',
    'smartmaps_smartmap'
);