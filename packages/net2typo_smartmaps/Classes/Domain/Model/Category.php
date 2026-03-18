<?php

declare(strict_types=1);

namespace NET2TYPO\Smartmaps\Domain\Model;

use TYPO3\CMS\Extbase\Domain\Model\FileReference;

/**
 * Category
 */
class Category extends \TYPO3\CMS\Extbase\Domain\Model\Category
{
    /**
     * Map marker image
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference|null
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $mapMarker = null;

    /**
     * Whether to use original image size
     *
     * @var bool
     */
    protected $mapImageSize = false;

    /**
     * Custom image width
     *
     * @var int
     */
    protected $mapImageWidth = 0;

    /**
     * Custom image height
     *
     * @var int
     */
    protected $mapImageHeight = 0;

    public function getMapMarker(): ?FileReference
    {
        return $this->mapMarker;
    }

    public function setMapMarker(FileReference $mapMarker): void
    {
        $this->mapMarker = $mapMarker;
    }

    public function isMapImageSize(): bool
    {
        return $this->mapImageSize;
    }

    public function setMapImageSize(bool $mapImageSize): void
    {
        $this->mapImageSize = $mapImageSize;
    }

    public function getMapImageWidth(): int
    {
        return $this->mapImageWidth;
    }

    public function setMapImageWidth(int $mapImageWidth): void
    {
        $this->mapImageWidth = $mapImageWidth;
    }

    public function getMapImageHeight(): int
    {
        return $this->mapImageHeight;
    }

    public function setMapImageHeight(int $mapImageHeight): void
    {
        $this->mapImageHeight = $mapImageHeight;
    }
}
