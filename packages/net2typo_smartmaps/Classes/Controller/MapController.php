<?php

declare(strict_types=1);

namespace NET2TYPO\Smartmaps\Controller;

use TYPO3\CMS\Core\Http\JsonResponse;
use NET2TYPO\Smartmaps\Domain\Model\Map;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Page\PageRenderer;

/**
 * This file is part of the "smartmaps" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2025 
 */

/**
 * MapController
 */
class MapController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController        
{
    /**
     * mapRepository
     *
     * @var \NET2TYPO\Smartmaps\Domain\Repository\MapRepository
     */
    protected $mapRepository = null;

    /**
     * @param \NET2TYPO\Smartmaps\Domain\Repository\MapRepository $mapRepository
     */
    public function injectMapRepository(\NET2TYPO\Smartmaps\Domain\Repository\MapRepository $mapRepository)
    {
        $this->mapRepository = $mapRepository;
    }

    public function fetchAction(){
        if (!isset($_POST['street']) || !isset($_POST['zip']) || !isset($_POST['city']) || !isset($_POST['country'])) {
            return new JsonResponse(['error' => 'Missing parameters'], 400);
        }
        $response = $this->callYellowMapApi($_POST['street'], $_POST['zip'], $_POST['city'], $_POST['country']);
 
        return new JsonResponse($response);
    }   

    private function callYellowMapApi(string $street, string $zip, string $city, string $country): ?array
    {
 	
        $smartMapsLibrary =  'https://www.yellowmap.de/api_rst/v2/geojson/geocode?apiKey=';
        if (isset($this->settings['apiKey']) && !empty($this->settings['apiKey'])) {
            $smartMapsLibrary .=  $this->settings['apiKey'];
        }

        $payload = [
            'type' => 'Feature',
            'properties' => new \stdClass(),
            'geometry' => [
                'type' => 'Point',
                'coordinates' => [0, 0]
            ],
            'crs' => [
                'type' => 'name',
                'properties' => [
                    'name' => 'urn:ogc:def:crs:OGC:1.3:CRS84'
                ]
            ],
            'searchparams' => [
                'geocodingType' => 'GEOCODE',
                'coordFormatOut' => 'GEODECIMAL_POINT'
            ],
            'authentication' => [
                'channel' => 'Test123'
            ],
            'location' => [
                'country' => $country,
                'district' => '',
                'zip' => $zip,
                'city' => $city,
                'cityAddOn' => '',
                'cityPart' => '',
                'street' => $street,
                'houseNo' => '',
                'singleSlot' => ''
            ]
        ];

        $url = $smartMapsLibrary;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Request Error: ' . curl_error($ch);
            curl_close($ch);
            exit;
        }

        curl_close($ch);

        $data = json_decode($response, true);

        if (isset($data['features'][0]['geometry']['coordinates'])) {
            $coords = $data['features'][0]['geometry']['coordinates'];
            return $coords;
        } else {
            return $data; 
        }

    }

    /**
     */
    public function showMapAction(?Map $map = null): \Psr\Http\Message\ResponseInterface
    {

        $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
      
        if (!empty($this->settings['apiKey'])) {
            $apiKey = $this->settings['apiKey'];
    
            // Load base YellowMap library (free-3)
            $pageRenderer->addJsLibrary(
                'yellowmap-free',
                'https://www.yellowmap.de/api_rst/api/loader?libraries=free-3&apiKey=' . $apiKey,
                'text/javascript',
                false,
                false,
                '',
                true // forceOnTop to ensure it's loaded early
            );
        }
  
        // get current map
        if(is_null($map) && isset($this->settings['map'])) {
            $map = $this->mapRepository->findByUid($this->settings['map']);
        }

        if (is_null($map)) {
            return $this->htmlResponse();
        }

        // find addresses
        $addresses = $map->getAddress();
        $siteLanguage = $this->request->getAttribute('language');
        $languageCode = $siteLanguage ? $siteLanguage->getLocale()->getLanguageCode() : 'en';
        if (isset($this->settings['enableCategoryFilter']) && $this->settings['enableCategoryFilter']) {
            $uniqueCategories = [];
            $categoryUids = [];
            if ($addresses) {
                foreach ($addresses as $address) {
                    foreach ($address->getCategories() as $category) {
                        if (!in_array($category->getUid(), $categoryUids)) {
                            $categoryUids[] = $category->getUid();
                            $uniqueCategories[] = $category;
                        }
                    }
                }
            }
            $this->view->assign('categories', $uniqueCategories);
        }
        $currentContentObject = $this->request->getAttribute('currentContentObject');
        $uid = $currentContentObject->data['uid'];
        $this->view->assignMultiple([
            'request' => $this->request->getArguments(),
            'map' => $map,
            'addresses' => $addresses,
            'languageCode' => $languageCode,
            'data' => $uid,
        ]);
        return $this->htmlResponse();
    }
}
