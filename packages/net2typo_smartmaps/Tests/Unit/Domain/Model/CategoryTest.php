<?php

declare(strict_types=1);

namespace NET2TYPO\Smartmaps\Tests\Unit\Domain\Model;

use NET2TYPO\Smartmaps\Domain\Model\Category;
use PHPUnit\Framework\TestCase;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;

final class CategoryTest extends TestCase
{
    public function testMapMarkerCanBeSetAndRetrieved(): void
    {
        $subject = new Category();
        $mapMarker = $this->createMock(FileReference::class);

        $subject->setMapMarker($mapMarker);

        self::assertSame($mapMarker, $subject->getMapMarker());
    }

    public function testMapImageFlagsAndDimensionsCanBeSetAndRetrieved(): void
    {
        $subject = new Category();

        $subject->setMapImageSize(true);
        $subject->setMapImageWidth(120);
        $subject->setMapImageHeight(80);

        self::assertTrue($subject->isMapImageSize());
        self::assertSame(120, $subject->getMapImageWidth());
        self::assertSame(80, $subject->getMapImageHeight());
    }
}
