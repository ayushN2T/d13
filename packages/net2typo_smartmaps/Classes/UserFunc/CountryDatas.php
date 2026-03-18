<?php

declare(strict_types=1);

namespace NET2TYPO\Smartmaps\UserFunc;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Country\CountryProvider;
use TYPO3\CMS\Core\Localization\LanguageServiceFactory;
use TYPO3\CMS\Core\Site\Entity\SiteLanguage;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class CountryDatas
{
    public function getCountryOptions(array &$data): void
    {
        $countryProvider = $this->getCountryProvider();
        $languageServiceFactory = $this->getLanguageServiceFactory();

        $request = $GLOBALS['TYPO3_REQUEST'];
        $languageService = null;

        if ($request instanceof ServerRequestInterface && $request->getAttribute('language') instanceof SiteLanguage) {
            $languageService = $languageServiceFactory->createFromSiteLanguage($request->getAttribute('language'));
        }

        $countries = $countryProvider->getAll();
        $items = [];

        foreach ($countries as $country) {
            $label = $languageService !== null
                ? $languageService->sL($country->getLocalizedNameLabel())
                : $country->getName();

            $value = $country->getAlpha2IsoCode(); // e.g., "IN"

            $items[] = [$label, $value];
        }

        // Sort by label
        usort($items, fn($a, $b) => strcmp($a[0], $b[0]));

        $data['items'] = $items;
    }

    protected function getCountryProvider(): CountryProvider
    {
        return GeneralUtility::makeInstance(CountryProvider::class);
    }

    protected function getLanguageServiceFactory(): LanguageServiceFactory
    {
        return GeneralUtility::makeInstance(LanguageServiceFactory::class);
    }
}
