<?php

declare(strict_types=1);

namespace NET2TYPO\Smartmaps\Domain\Model;


/**
 * This file is part of the "smartmaps" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2025 
 */

/**
 * Map
 */
class Map extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * title
     *
     * @var string
     */
    protected $title = '';

    /**
     * width
     *
     * @var string
     */
    protected $width = null;

    /**
     * height
     *
     * @var string
     */
    protected $height = null;

    /**
     * zoom
     *
     * @var int
     */
    protected $zoom = null;

    /**
     * zoomMin
     *
     * @var int
     */
    protected $zoomMin = null;

    /**
     * zoomMax
     *
     * @var int
     */
    protected $zoomMax = null;

    /**
     * defaultType
     *
     * @var int
     */
    protected $defaultType = null;

    /**
     * longitude
     *
     * @var float
     */
    protected $longitude = null;

    /**
     * latitude
     *
     * @var float
     */
    protected $latitude = null;

    /**
     * markerCluster
     *
     * @var bool
     */
    protected $markerCluster = null;

    /**
     * markerClusterZoom
     *
     * @var int
     */
    protected $markerClusterZoom = null;

    /**
     * markerClusterSize
     *
     * @var int
     */
    protected $markerClusterSize = null;

    /**
     * marker
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $defaultmarker;

    /**
     * address
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\NET2TYPO\Smartmaps\Domain\Model\Address>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $address = null;

    /**
     * __construct
     */
    public function __construct()
    {

        // Do not remove the next line: It would break the functionality
        $this->initializeObject();
    }

    /**
     * Initializes all ObjectStorage properties when model is reconstructed from DB (where __construct is not called)
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     *
     * @return void
     */
    public function initializeObject()
    {
        $this->address = $this->address ?: new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Returns the title
     *
     * @return string
     */
    public function getTitle()
    {
        return preg_replace('/[^a-zA-Z0-9]/', '', $this->title);
    }

    /**
     * Sets the title
     *
     * @param string $title
     * @return void
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * Returns the width
     *
     * @return string
     */
    public function getWidth()
    {
        return is_numeric($this->width) ? $this->width . 'px' : $this->width;
    }

    /**
     * Sets the width
     *
     * @param string $width
     * @return void
     */
    public function setWidth(string $width)
    {
        $this->width = $width;
    }

    /**
     * Returns the height
     *
     * @return string
     */
    public function getHeight()
    {
        return is_numeric($this->height) ? $this->height . 'px' : $this->height;
    }

    /**
     * Sets the height
     *
     * @param string $height
     * @return void
     */
    public function setHeight(string $height)
    {
        $this->height = $height;
    }

    /**
     * Returns the zoom
     *
     * @return int
     */
    public function getZoom()
    {
        return $this->zoom;
    }

    /**
     * Sets the zoom
     *
     * @param int $zoom
     * @return void
     */
    public function setZoom(int $zoom)
    {
        $this->zoom = $zoom;
    }

    /**
     * Returns the zoomMin
     *
     * @return int
     */
    public function getZoomMin()
    {
        return $this->zoomMin;
    }

    /**
     * Sets the zoomMin
     *
     * @param int $zoomMin
     * @return void
     */
    public function setZoomMin(int $zoomMin)
    {
        $this->zoomMin = $zoomMin;
    }

    /**
     * Returns the zoomMax
     *
     * @return int
     */
    public function getZoomMax()
    {
        return $this->zoomMax;
    }

    /**
     * Sets the zoomMax
     *
     * @param int $zoomMax
     * @return void
     */
    public function setZoomMax(int $zoomMax)
    {
        $this->zoomMax = $zoomMax;
    }

    /**
     * Returns the defaultType
     *
     * @return int
     */
    public function getDefaultType()
    {
        return $this->defaultType;
    }

    /**
     * Sets the defaultType
     *
     * @param int $defaultType
     * @return void
     */
    public function setDefaultType(int $defaultType)
    {
        $this->defaultType = $defaultType;
    }

    /**
     * Returns the longitude
     *
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Sets the longitude
     *
     * @param float $longitude
     * @return void
     */
    public function setLongitude(float $longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * Returns the latitude
     *
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Sets the latitude
     *
     * @param float $latitude
     * @return void
     */
    public function setLatitude(float $latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * Returns the markerCluster
     *
     * @return bool
     */
    public function getMarkerCluster()
    {
        return $this->markerCluster;
    }

    /**
     * Sets the markerCluster
     *
     * @param bool $markerCluster
     * @return void
     */
    public function setMarkerCluster(bool $markerCluster)
    {
        $this->markerCluster = $markerCluster;
    }

    /**
     * Returns the markerClusterZoom
     *
     * @return int
     */
    public function getMarkerClusterZoom()
    {
        return $this->markerClusterZoom;
    }

    /**
     * Sets the markerClusterZoom
     *
     * @param int $markerClusterZoom
     * @return void
     */
    public function setMarkerClusterZoom(int $markerClusterZoom)
    {
        $this->markerClusterZoom = $markerClusterZoom;
    }

    /**
     * Returns the markerClusterSize
     *
     * @return int
     */
    public function getMarkerClusterSize()
    {
        return $this->markerClusterSize;
    }

    /**
     * Sets the markerClusterSize
     *
     * @param int $markerClusterSize
     * @return void
     */
    public function setMarkerClusterSize(int $markerClusterSize)
    {
        $this->markerClusterSize = $markerClusterSize;
    }

    /**
     * Returns the defaultmarker
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    public function getDefaultmarker()
    {
        return $this->defaultmarker;
    }

    /**
     * Sets the defaultmarker
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $defaultmarker
     * @return void
     */
    public function setDefaultmarker(\TYPO3\CMS\Extbase\Domain\Model\FileReference $defaultmarker)
    {
        $this->defaultmarker = $defaultmarker;
    }

    /**
     * Adds a Address
     *
     * @param \NET2TYPO\Smartmaps\Domain\Model\Address $addres
     * @return void
     */
    public function addAddres(\NET2TYPO\Smartmaps\Domain\Model\Address $addres)
    {
        $this->address->attach($addres);
    }

    /**
     * Removes a Address
     *
     * @param \NET2TYPO\Smartmaps\Domain\Model\Address $addresToRemove The Address to be removed
     * @return void
     */
    public function removeAddres(\NET2TYPO\Smartmaps\Domain\Model\Address $addresToRemove)
    {
        $this->address->detach($addresToRemove);
    }

    /**
     * Returns the address
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\NET2TYPO\Smartmaps\Domain\Model\Address>
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Sets the address
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\NET2TYPO\Smartmaps\Domain\Model\Address> $address
     * @return void
     */
    public function setAddress(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $address)
    {
        $this->address = $address;
    }
}