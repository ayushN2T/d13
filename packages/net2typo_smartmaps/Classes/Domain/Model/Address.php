<?php

declare(strict_types=1);

namespace NET2TYPO\Smartmaps\Domain\Model;

use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * This file is part of the "smartmaps" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2025 
 */

/**
 * Address
 */
class Address extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * title
     *
     * @var string
     */
    protected $title = null;

    /**
     * street
     *
     * @var string
     */
    protected $street = null;

    /**
     * city
     *
     * @var string
     */
    protected $city = null;

    /**
     * zip
     *
     * @var string
     */
    protected $zip = null;

    /**
     * country
     *
     * @var string
     */
    protected $country = null;

    /**
     * latitude
     *
     * @var float
     */
    protected $latitude = null;

    /**
     * longitude
     *
     * @var float
     */
    protected $longitude = null;

    /**
     * marker
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $marker = null;

    /**
     * configurationMap
     *
     * @var string
     */
    protected $configurationMap = null;

    /**
     * imageSize
     *
     * @var int
     */
    protected $imageSize = null;

    /**
     * imageWidth
     *
     * @var int
     */
    protected $imageWidth = null;

    /**
     * imageHeight
     *
     * @var int
     */
    protected $imageHeight = null;

    /**
     * infoWindowContent
     *
     * @var string
     */
    protected $infoWindowContent = null;

    /**
     * infoWindowImage
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $infoWindowImage = null;

    /**
     * categories
     *
     * @var ObjectStorage<\NET2TYPO\Smartmaps\Domain\Model\Category>
     */
    protected ?ObjectStorage $categories = null;

    /**
     * __construct
     */
    public function __construct()
    {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }

    /**
     * Initializes all \TYPO3\CMS\Extbase\Persistence\ObjectStorage properties.
     */
    protected function initStorageObjects()
    {
        /**
         * Do not modify this method!
         * It will be rewritten on each save in the extension builder
         * You may modify the constructor of this class instead
         */
        $this->categories = new ObjectStorage();
    }

    /**
     * Returns the title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
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
     * Returns the street
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Sets the street
     *
     * @param string $street
     * @return void
     */
    public function setStreet(string $street)
    {
        $this->street = $street;
    }

    /**
     * Returns the city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Sets the city
     *
     * @param string $city
     * @return void
     */
    public function setCity(string $city)
    {
        $this->city = $city;
    }

    /**
     * Returns the zip
     *
     * @return string
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * Sets the zip
     *
     * @param string $zip
     * @return void
     */
    public function setZip(string $zip)
    {
        $this->zip = $zip;
    }

    /**
     * Returns the country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Sets the country
     *
     * @param string $country
     * @return void
     */
    public function setCountry(string $country)
    {
        $this->country = $country;
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
     * Returns the marker
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    public function getMarker()
    {
        return $this->marker;
    }

    /**
     * Sets the marker
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $marker
     * @return void
     */
    public function setMarker(\TYPO3\CMS\Extbase\Domain\Model\FileReference $marker)
    {
        $this->marker = $marker;
    }

    /**
     * Returns the configurationMap
     *
     * @return string
     */
    public function getConfigurationMap()
    {
        return $this->configurationMap;
    }

    /**
     * Sets the configurationMap
     *
     * @param string $configurationMap
     * @return void
     */
    public function setConfigurationMap(string $configurationMap)
    {
        $this->configurationMap = $configurationMap;
    }

    /**
     * Returns the imageSize
     *
     * @return int
     */
    public function getImageSize()
    {
        return $this->imageSize;
    }

    /**
     * Sets the imageSize
     *
     * @param int $imageSize
     * @return void
     */
    public function setImageSize(int $imageSize)
    {
        $this->imageSize = $imageSize;
    }

    /**
     * Returns the imageWidth
     *
     * @return int
     */
    public function getImageWidth()
    {
        return $this->imageWidth;
    }

    /**
     * Sets the imageWidth
     *
     * @param int $imageWidth
     * @return void
     */
    public function setImageWidth(int $imageWidth)
    {
        $this->imageWidth = $imageWidth;
    }

    /**
     * Returns the imageHeight
     *
     * @return int
     */
    public function getImageHeight()
    {
        return $this->imageHeight;
    }

    /**
     * Sets the imageHeight
     *
     * @param int $imageHeight
     * @return void
     */
    public function setImageHeight(int $imageHeight)
    {
        $this->imageHeight = $imageHeight;
    }

    /**
     * Returns the infoWindowContent
     *
     * @return string
     */
    public function getInfoWindowContent()
    {
        return $this->infoWindowContent;
    }

    /**
     * Sets the infoWindowContent
     *
     * @param string $infoWindowContent
     * @return void
     */
    public function setInfoWindowContent(string $infoWindowContent)
    {
        $this->infoWindowContent = $infoWindowContent;
    }

    /**
     * Returns the infoWindowImage
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    public function getInfoWindowImage()
    {
        return $this->infoWindowImage;
    }

    /**
     * Sets the infoWindowImage
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $infoWindowImage
     * @return void
     */
    public function setInfoWindowImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $infoWindowImage)
    {
        $this->infoWindowImage = $infoWindowImage;
    }

    public function addCategories(Category $category): void
    {
        $this->categories->attach($category);
    }

    public function removeCategories(Category $categoryToRemove): void
    {
        $this->categories->detach($categoryToRemove);
    }

    /**
     * @return ObjectStorage<Category>|null
     */
    public function getCategories(): ?ObjectStorage
    {
        return $this->categories;
    }

    /**
     * @param ObjectStorage<Category> $categories
     */
    public function setCategories(ObjectStorage $categories): void
    {
        $this->categories = $categories;
    }
}