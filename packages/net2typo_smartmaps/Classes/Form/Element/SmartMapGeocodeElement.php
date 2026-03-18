<?php

namespace NET2TYPO\Smartmaps\Form\Element;

use TYPO3\CMS\Backend\Form\Element\AbstractFormElement;
use TYPO3\CMS\Core\Page\AssetCollector;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Core\RequestId;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Fluid\ViewHelpers\Security\NonceViewHelper;

class SmartMapGeocodeElement extends AbstractFormElement
{
    public function render(): array
    {
        $resultArray = $this->initializeResultArray();
        $pluginSettings = static::getSettings();

        $assetCollector = GeneralUtility::makeInstance(AssetCollector::class);
      
        $smartMapsLibrary =  $pluginSettings['smartMapsLibrary'] ?? 'https://www.yellowmap.de/api_rst/v2/geojson/geocode';
        if (isset($pluginSettings['apiKey']) && !empty($pluginSettings['apiKey'])) {
            $smartMapsLibrary .= '?apiKey=' . $pluginSettings['apiKey'];
        }


        $out = [];
        $latitude = (float)$this->data['databaseRow'][$this->data['parameterArray']['fieldConf']['config']['parameters']['latitude']];
        $longitude = (float)$this->data['databaseRow'][$this->data['parameterArray']['fieldConf']['config']['parameters']['longitude']];

        $baseElementId = isset($this->data['databaseRow']['uid']) ? $this->data['databaseRow']['uid'] : $this->data['tableName'] . '_map';

        if (!($latitude && $longitude)) {
            $latitude = 0;
            $longitude = 0;
        }
        $dataPrefix = 'data[' . $this->data['tableName'] . '][' . $this->data['databaseRow']['uid'] . ']';
        $latitudeField = $dataPrefix . '[' . $this->data['parameterArray']['fieldConf']['config']['parameters']['latitude'] . ']';
        $longitudeField = $dataPrefix . '[' . $this->data['parameterArray']['fieldConf']['config']['parameters']['longitude'] . ']';
        $streetFieldName = $dataPrefix . '[' . $this->data['parameterArray']['fieldConf']['config']['parameters']['street'] . ']';
        $zipFieldName = $dataPrefix . '[' . $this->data['parameterArray']['fieldConf']['config']['parameters']['zip'] . ']';
        $cityFieldName = $dataPrefix . '[' . $this->data['parameterArray']['fieldConf']['config']['parameters']['city'] . ']';
        $countryFieldName = $dataPrefix . '[' . $this->data['parameterArray']['fieldConf']['config']['parameters']['country'] . ']';

        //$response = $this->callYellowMapApi($street, $zip, $city, $country);
 
        $baseElementId = $this->data['databaseRow']['uid'] ?? uniqid('smartmap_', true);
        $htmlId = htmlspecialchars($baseElementId);
        $dataPrefix = 'data[' . $this->data['tableName'] . '][' . $this->data['databaseRow']['uid'] . ']';

        $nonceViewHelper = GeneralUtility::makeInstance(NonceViewHelper::class);
        $nonce = $nonceViewHelper->render();
        $buttonId = $htmlId . '_logButton';
        if (empty($pluginSettings['apiKey'])) {
            $out[] = '<div style="color: red; background: #ffe2e2; border: 1px solid red; padding: 10px; margin-top: 10px;">
                <strong>Missing API Key:</strong> Please enter your API key in the <code>Constants</code> of your TypoScript setup. <br>
                Go to <strong>Template → Constants</strong> and add:<br>
                <code>plugin.tx_smartmaps.settings.apiKey = YOUR_API_KEY</code>
            </div>';
        } else {
            $out[] = '<br>';
            $out[] = '<button 
                type="button" 
                id="' . $buttonId . '" 
                class="btn btn-primary t3js-btn-update-geocode" 
                style="margin: 10px 0; padding: 6px 16px; font-size: 14px; border-radius: 4px;">
                <i class="fa fa-map-marker-alt" style="margin-right: 5px;"></i> Update Coordinates
            </button>';
            
            $out[] = '<div id="geocode-error-message" style="color: red; display: none; margin-top: 10px;">
                Please check your entered data (street, city, zip, country) and try again. Coordinates not found for given data.
            </div>';
            
            // Get the current domain dynamically
            $domain = GeneralUtility::getIndpEnv('TYPO3_REQUEST_HOST');
            $geocodeUrl = $domain . '/?type=1751262396';

            $out[] = '<script type="text/javascript" async nonce="' . $nonce . '">
            document.addEventListener("DOMContentLoaded", function () {
                var logBtn = document.getElementById("' . $buttonId . '");
                var errorMsg = document.getElementById("geocode-error-message");
                // Use PHP variable for the endpoint
                var geocodeUrl = ' . json_encode($geocodeUrl) . ';
                
                if (logBtn) {
                    logBtn.addEventListener("click", function () {
                        var street = document.getElementsByName("' . $streetFieldName . '")[0]?.value || "";
                        var zip = document.getElementsByName("' . $zipFieldName . '")[0]?.value || "";
                        var city = document.getElementsByName("' . $cityFieldName . '")[0]?.value || "";
                        var country = document.getElementsByName("' . $countryFieldName . '")[0]?.value || "";

                        console.log("Street:", street);
                        console.log("Zip:", zip);
                        console.log("City:", city);
                        console.log("Country:", country);

                        fetch(geocodeUrl, {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/x-www-form-urlencoded"
                            },
                            body: new URLSearchParams({
                                street: street,
                                zip: zip,
                                city: city,
                                country: country
                            })
                        })
                        .then(response => response.json())
                        .then(response => {
                            // Check if lat/lng found (assuming response array format or fallback JSON structure)
                            if (Array.isArray(response) && response.length === 2) {
                                var longitude = response[0];
                                var latitude = response[1];
            
                                // Hide error message
                                if (errorMsg) errorMsg.style.display = "none";
            
                                // Set values in TCA form
                                document.getElementsByName("' . $latitudeField . '")[0].value = latitude;
                                document.getElementsByName("' . $longitudeField . '")[0].value = longitude;
            
                                document.getElementsByName("' . $latitudeField . '")[0].dispatchEvent(new Event("change", { bubbles: true }));
                                document.getElementsByName("' . $longitudeField . '")[0].dispatchEvent(new Event("change", { bubbles: true }));
            
                                var latInput = document.querySelector(\'[data-formengine-input-name="' . $latitudeField . '"]\');
                                var lngInput = document.querySelector(\'[data-formengine-input-name="' . $longitudeField . '"]\');
            
                                if (latInput) {
                                    latInput.value = latitude;
                                    latInput.dispatchEvent(new Event("change", { bubbles: true }));
                                }
                                if (lngInput) {
                                    lngInput.value = longitude;
                                    lngInput.dispatchEvent(new Event("change", { bubbles: true }));
                                }
                            } else if (response && response.properties && response.features && Array.isArray(response.features) && response.features.length === 0) {
                                // Show error message when lat/lng not found
                                if (errorMsg) errorMsg.style.display = "block";
                            } else {
                                // Unknown format or error
                                if (errorMsg) errorMsg.style.display = "block";
                            }
                        })
                        .catch(error => {
                            console.error("Fetch error:", error);
                            if (errorMsg) errorMsg.style.display = "block";
                        });
                    });
                }
            });
            </script>';
        }
        
        
        
        $resultArray['html'] = implode('', $out);

        return $resultArray;
    }

     /**
     * Get definitive TypoScript Settings from
     * plugin.tx_gomapsext.settings.
     */
    private static function getSettings(): array
    {
        return GeneralUtility::makeInstance(ConfigurationManagerInterface::class)
            ->getConfiguration(
                ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT
            )['plugin.']['tx_smartmaps_smartmap.']['settings.'] ?? [];
    }
}
