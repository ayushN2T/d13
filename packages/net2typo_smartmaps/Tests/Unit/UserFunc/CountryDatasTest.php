<?php

declare(strict_types=1);

namespace NET2TYPO\Smartmaps\Tests\Unit\UserFunc;

use NET2TYPO\Smartmaps\UserFunc\CountryDatas;
use PHPUnit\Framework\TestCase;
use TYPO3\CMS\Core\Country\CountryProvider;
use TYPO3\CMS\Core\Localization\LanguageServiceFactory;

final class CountryDatasTest extends TestCase
{
    protected function tearDown(): void
    {
        unset($GLOBALS['TYPO3_REQUEST']);
        parent::tearDown();
    }

    public function testGetCountryOptionsReturnsSortedCountryPairs(): void
    {
        $GLOBALS['TYPO3_REQUEST'] = null;
        $data = ['items' => []];

        $countryOne = new class() {
            public function getName(): string
            {
                return 'Zulu';
            }

            public function getAlpha2IsoCode(): string
            {
                return 'ZU';
            }

            public function getLocalizedNameLabel(): string
            {
                return 'label.zulu';
            }
        };

        $countryTwo = new class() {
            public function getName(): string
            {
                return 'Alpha';
            }

            public function getAlpha2IsoCode(): string
            {
                return 'AL';
            }

            public function getLocalizedNameLabel(): string
            {
                return 'label.alpha';
            }
        };

        $countryProvider = $this->createMock(CountryProvider::class);
        $countryProvider
            ->method('getAll')
            ->willReturn([$countryOne, $countryTwo]);

        $languageServiceFactory = $this->createMock(LanguageServiceFactory::class);

        $subject = new class($countryProvider, $languageServiceFactory) extends CountryDatas {
            public function __construct(
                private readonly CountryProvider $countryProvider,
                private readonly LanguageServiceFactory $languageServiceFactory,
            ) {
            }

            protected function getCountryProvider(): CountryProvider
            {
                return $this->countryProvider;
            }

            protected function getLanguageServiceFactory(): LanguageServiceFactory
            {
                return $this->languageServiceFactory;
            }
        };

        $subject->getCountryOptions($data);

        self::assertSame(
            [
                ['Alpha', 'AL'],
                ['Zulu', 'ZU'],
            ],
            $data['items'],
        );
    }
}
