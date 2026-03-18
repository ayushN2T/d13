<?php

/*
 *  This file is part of the JonathanHeilmann\JhMagnificpopup extension under GPLv2 or later.
 *
 *  For the full copyright and license information, please read the
 *  LICENSE.md file that was distributed with this source code.
 */

namespace NET2TYPO\Smartmaps\ViewHelpers;

use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Core\Core\Environment; 

/**
 * Class AddJsInlineCodeViewHelper
 */
class AddJsInlineCodeViewHelper extends AbstractViewHelper
{
    public function initializeArguments()

    {
$this->registerArgument('content', 'string', 'JS code to write and load', true);
        $this->registerArgument('filename', 'string', 'Optional filename for the script', false);
        $this->registerArgument('inline', 'bool', 'If true, adds inline JS, else loads file', false, false);
        $this->registerArgument('addDefer', 'bool', 'Add defer attribute', false, true);
    }

 public function render(): string
    {
        $content = $this->arguments['content'];
        $filename = $this->arguments['filename'] ?? 'script-' . md5($content) . '.js';
        $isInline = $this->arguments['inline'];
        $addDefer = $this->arguments['addDefer'];

        $relativePathInTypo3Temp = 'smartmaps/js/' . $filename;
        $publicUrlPath = '/typo3temp/' . $relativePathInTypo3Temp;
        $absolutePath = Environment::getPublicPath() . '/typo3temp/' . $relativePathInTypo3Temp;

        if (!file_exists(dirname($absolutePath))) {
            GeneralUtility::mkdir_deep(dirname($absolutePath));
        }

        if (!file_exists($absolutePath)) {
            GeneralUtility::writeFile($absolutePath, $content);
        }else{
            GeneralUtility::writeFile($absolutePath, $content);
        }

        $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
        
        if ($isInline) {
            $pageRenderer->addJsInlineCode($filename, $content);
        } else {
            $pageRenderer->addJsFooterFile($publicUrlPath, 'text/javascript', 'utf-8', false, '', $addDefer);
        }

        return '';
    }
}
