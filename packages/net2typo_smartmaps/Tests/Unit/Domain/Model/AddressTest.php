<?php

declare(strict_types=1);

namespace NET2TYPO\Smartmaps\Tests\Unit\Domain\Model;

use NET2TYPO\Smartmaps\Domain\Model\Address;
use NET2TYPO\Smartmaps\Domain\Model\Category;
use PHPUnit\Framework\TestCase;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

final class AddressTest extends TestCase
{
    public function testConstructorInitializesCategoryStorage(): void
    {
        $subject = new Address();

        self::assertInstanceOf(ObjectStorage::class, $subject->getCategories());
        self::assertCount(0, $subject->getCategories());
    }

    public function testScalarPropertiesCanBeSetAndRetrieved(): void
    {
        $subject = new Address();

        $subject->setTitle('Office');
        $subject->setStreet('Main Street 1');
        $subject->setCity('Berlin');
        $subject->setZip('10115');
        $subject->setCountry('DE');
        $subject->setLatitude(52.52);
        $subject->setLongitude(13.405);
        $subject->setConfigurationMap('dark');
        $subject->setImageSize(1);
        $subject->setImageWidth(300);
        $subject->setImageHeight(200);
        $subject->setInfoWindowContent('Hello');

        self::assertSame('Office', $subject->getTitle());
        self::assertSame('Main Street 1', $subject->getStreet());
        self::assertSame('Berlin', $subject->getCity());
        self::assertSame('10115', $subject->getZip());
        self::assertSame('DE', $subject->getCountry());
        self::assertSame(52.52, $subject->getLatitude());
        self::assertSame(13.405, $subject->getLongitude());
        self::assertSame('dark', $subject->getConfigurationMap());
        self::assertSame(1, $subject->getImageSize());
        self::assertSame(300, $subject->getImageWidth());
        self::assertSame(200, $subject->getImageHeight());
        self::assertSame('Hello', $subject->getInfoWindowContent());
    }

    public function testFileReferencePropertiesCanBeSetAndRetrieved(): void
    {
        $subject = new Address();
        $marker = $this->createMock(FileReference::class);
        $infoWindowImage = $this->createMock(FileReference::class);

        $subject->setMarker($marker);
        $subject->setInfoWindowImage($infoWindowImage);

        self::assertSame($marker, $subject->getMarker());
        self::assertSame($infoWindowImage, $subject->getInfoWindowImage());
    }

    public function testCategoriesCanBeAddedAndRemoved(): void
    {
        $subject = new Address();
        $category = new Category();

        $subject->addCategories($category);

        self::assertCount(1, $subject->getCategories());
        self::assertTrue($subject->getCategories()->contains($category));

        $subject->removeCategories($category);

        self::assertCount(0, $subject->getCategories());
        self::assertFalse($subject->getCategories()->contains($category));
    }

    public function testCategoriesStorageCanBeReplaced(): void
    {
        $subject = new Address();
        $category = new Category();
        $storage = new ObjectStorage();
        $storage->attach($category);

        $subject->setCategories($storage);

        self::assertSame($storage, $subject->getCategories());
        self::assertCount(1, $subject->getCategories());
    }
}
