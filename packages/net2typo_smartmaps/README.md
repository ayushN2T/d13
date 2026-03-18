# SmartMap for TYPO3

[![TYPO3 Version](https://img.shields.io/badge/TYPO3-v13LTS-orange.svg)](https://typo3.org/)
[![License](https://img.shields.io/badge/license-GPL--2.0--or--later-blue.svg)](https://www.gnu.org/licenses/gpl-2.0.html)

The SmartMap extension provides a seamless integration of the Yellowmap service into your TYPO3 website. It allows you to easily display highly customizable maps with multiple markers, info windows, and marker clustering.

## Key Features

- **Dynamic Maps:** Display maps on your website using data from the Yellowmap API.
- **Easy Geocoding:** Automatically fetch coordinates (latitude & longitude) for your addresses with a single click in the TYPO3 backend.
- **Record Management:** Manage `Map` and `Address` records directly within the TYPO3 backend.
- **Custom Markers:** Use default markers for the map and custom markers for individual addresses.
- **Marker Clustering:** Automatically group nearby markers into clusters for better readability on dense maps.
- **Category-wise Filtering:** Allow users to filter addresses on the map by category.
- **Info Windows:** Add rich content and images to info windows for each marker.
- **Flexible Configuration:** Customize map dimensions, zoom levels, center coordinates, map styles (light, dark, greyscale), and more.
- **Developer-Friendly:** Comes with a pre-configured DDEV environment for easy local development and testing.

## Installation


1.  **Get the extension:**
    Install the extension via Composer:
    ```bash
    composer require net2typo/smartmaps
    ```

2.  **Activate the extension:**
    Go to the Extension Manager in the TYPO3 backend and activate the `smartmaps` extension.

3.  **Include TypoScript:**
    Go to your root template record (`Template` > `Info/Modify`) and include the "SmartMaps" static TypoScript.

## Configuration

1.  **Set API Key:**
    You need a Yellowmap API key to use this extension.
    - Obtain your API key from [Yellowmap](https://www.yellowmap.de/).
    - Add the key to your TypoScript constants:
      ```typoscript
      plugin.tx_smartmaps_smartmaps.settings.apiKey = YOUR_API_KEY_HERE
      ```

2.  **Set Storage PID:**
    Specify the page ID where your `Map` and `Address` records are stored.
    ```typoscript
    plugin.tx_smartmaps_smartmaps.persistence.storagePid = YOUR_STORAGE_PID
    ```

## How to Use

1.  **Create Records:**
    - In the TYPO3 backend, go to the list module on the page you configured as your `storagePid`.
    - Create a new `Map` record and configure its settings (size, zoom, etc.).
    - Create `Address` records. For each address, you can fill in the street, city, zip, and country, then click the **"Update Coordinates"** button to automatically fetch the latitude and longitude.
    - Assign your `Address` records to the `Map` record.

2.  **Add Plugin to Page:**
    - Go to the page where you want to display the map.
    - Add a new content element and select "Smart Map" from the "Plugins" tab.
    - In the plugin options, select the `Map` record you created.

## Local Development & Contribution

This project includes a complete DDEV setup for easy local development.

## Testing

The extension is prepared for isolated PHPUnit and PHPStan runs from the extension root.

### Quick command list

Run these from the TYPO3 root project at `/home/net2t/projects/d13`:

```bash
# Start DDEV for the TYPO3 root project
ddev start

# Install extension dev dependencies
ddev exec bash -lc 'cd /var/www/html/packages/net2typo_smartmaps && composer install'

# Run unit tests
ddev exec bash -lc 'cd /var/www/html/packages/net2typo_smartmaps && php .Build/bin/phpunit -c phpunit.xml.dist'

# Run static analysis
ddev exec bash -lc 'cd /var/www/html/packages/net2typo_smartmaps && php .Build/bin/phpstan analyse -c phpstan.neon'

# Turn on Xdebug
ddev xdebug on

# Run unit tests with coverage
ddev exec bash -lc 'cd /var/www/html/packages/net2typo_smartmaps && XDEBUG_MODE=coverage php .Build/bin/phpunit -c phpunit.xml.dist --coverage-text'

# Turn off Xdebug again
ddev xdebug off
```

### Where tests run

The commands above run inside the `d13` DDEV `web` container, not the nested `smartmaps` DDEV project.

Inside the container the extension path is:

```text
/var/www/html/packages/net2typo_smartmaps
```

### Install dev dependencies

From the extension directory:

```bash
composer install
```

This installs the test tools into `.Build/`.

### Run PHPUnit

```bash
composer test:unit
```

### Run PHPStan

```bash
composer stan
```

### Run PHPUnit with coverage

Coverage requires Xdebug:

```bash
XDEBUG_MODE=coverage composer test:unit:coverage
```

### Using DDEV with Xdebug

If you want to run the extension using the already running TYPO3 root DDEV project:

```bash
ddev xdebug on
ddev exec bash -lc 'cd /var/www/html/packages/net2typo_smartmaps && composer test:unit'
ddev exec bash -lc 'cd /var/www/html/packages/net2typo_smartmaps && composer stan'
```

To turn Xdebug off again:

```bash
ddev xdebug off
```

### Prerequisites

- [DDEV](https://ddev.readthedocs.io/en/stable/users/install/ddev-installation/)

### Setup

1.  **Clone the repository:**
    ```bash
    git clone https://github.com/net2typo/net2typo_smartmaps.git
    cd smartmaps
    ```

2.  **Start DDEV:**
    ```bash
    ddev start
    ```
    The first time you start the project, a `post-start` hook will automatically run the `install-all` command. This sets up multiple TYPO3 instances for testing.

3.  **Access the Environments:**
    Once started, you can access the main project page and the different TYPO3 versions:
    - **Project Landing Page:** `https://smartmaps.ddev.site`
    - **TYPO3 v12:** `https://v12.smartmaps.ddev.site`

### Backend Access

- **User:** `admin`
- **Password:** `Net2typoteam@`

## License

This project is licensed under the GPL-2.0-or-later license. See the `LICENSE.txt` file for more details.
