<?php

declare(strict_types=1);

namespace NET2TYPO\Smartmaps\Tests\Unit\Domain\Model;

use NET2TYPO\Smartmaps\Domain\Model\Address;
use NET2TYPO\Smartmaps\Domain\Model\Map;
use PHPUnit\Framework\TestCase;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

final class MapTest extends TestCase
{
    public function testConstructorInitializesAddressStorage(): void
    {
        $subject = new Map();

        self::assertInstanceOf(ObjectStorage::class, $subject->getAddress());
        self::assertCount(0, $subject->getAddress());
    }

    public function testTitleIsSanitizedWhenRead(): void
    {
        $subject = new Map();

        $subject->setTitle('My Map #42 / Berlin');

        self::assertSame('MyMap42Berlin', $subject->getTitle());
    }

    public function testNumericWidthAndHeightAreReturnedWithPixelSuffix(): void
    {
        $subject = new Map();

        $subject->setWidth('600');
        $subject->setHeight('450');

        self::assertSame('600px', $subject->getWidth());
        self::assertSame('450px', $subject->getHeight());
    }

    public function testNonNumericWidthAndHeightAreReturnedUnchanged(): void
    {
        $subject = new Map();

        $subject->setWidth('100%');
        $subject->setHeight('calc(100vh - 20px)');

        self::assertSame('100%', $subject->getWidth());
        self::assertSame('calc(100vh - 20px)', $subject->getHeight());
    }

    public function testPrimitivePropertiesCanBeSetAndRetrieved(): void
    {
        $subject = new Map();

        $subject->setZoom(8);
        $subject->setZoomMin(4);
        $subject->setZoomMax(16);
        $subject->setDefaultType(2);
        $subject->setLongitude(13.405);
        $subject->setLatitude(52.52);
        $subject->setMarkerCluster(true);
        $subject->setMarkerClusterZoom(12);
        $subject->setMarkerClusterSize(64);

        self::assertSame(8, $subject->getZoom());
        self::assertSame(4, $subject->getZoomMin());
        self::assertSame(16, $subject->getZoomMax());
        self::assertSame(2, $subject->getDefaultType());
        self::assertSame(13.405, $subject->getLongitude());
        self::assertSame(52.52, $subject->getLatitude());
        self::assertTrue($subject->getMarkerCluster());
        self::assertSame(12, $subject->getMarkerClusterZoom());
        self::assertSame(64, $subject->getMarkerClusterSize());
    }

    public function testDefaultMarkerCanBeSetAndRetrieved(): void
    {
        $subject = new Map();
        $fileReference = $this->createMock(FileReference::class);

        $subject->setDefaultmarker($fileReference);

        self::assertSame($fileReference, $subject->getDefaultmarker());
    }

    public function testAddressCanBeAddedAndRemoved(): void
    {
        $subject = new Map();
        $address = new Address();

        $subject->addAddres($address);

        self::assertCount(1, $subject->getAddress());
        self::assertTrue($subject->getAddress()->contains($address));

        $subject->removeAddres($address);

        self::assertCount(0, $subject->getAddress());
        self::assertFalse($subject->getAddress()->contains($address));
    }

    public function testAddressStorageCanBeReplaced(): void
    {
        $subject = new Map();
        $address = new Address();
        $storage = new ObjectStorage();
        $storage->attach($address);

        $subject->setAddress($storage);

        self::assertSame($storage, $subject->getAddress());
        self::assertCount(1, $subject->getAddress());
    }
}
