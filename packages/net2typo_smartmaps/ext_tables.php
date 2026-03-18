<?php
defined('TYPO3') || die();

(static function() {
     // please insert your own code her
    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['smartmaps_smartmap'] = 'pi_flexform';
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
        'smartmaps_smartmap',
        'FILE:EXT:smartmaps/Configuration/FlexForms/flexform_smartmaps.xml'
    );
})();

