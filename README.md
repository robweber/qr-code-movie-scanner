# QR Code Movie Scanner

This project integrates your [Kodi library](https://kodi.tv) with a QR code generator. The result is a series of QR codes that you can apply to physical media (DVD cases) and scan them to have the digital movie play on your Kodi media player.

## Background

## Install

Before installation this assumes you have a working Apache with PHP web server up and running. This was tested on Linux but in theory any OS that can meet the requirements would work. Additionally for the Kodi integration to work you'll have to have [enabled web server access](https://kodi.wiki/view/Settings/Services/Control#Allow_remote_control_via_HTTP) on your Kodi device.

1. Clone the repo

```
git clone https://github.com/robweber/qr-code-movie-scanner.git
```

2. Ensure PHP libraries are installed

```
apt get install php-curl php-gd -y
systemctl restart apache2
```

3. Add Directory to Apache

This can be done a variety of ways, such as a subdirectory of an existing site or it's own virtual directory. Below is the Apache config to add it as a directory to an existing site. Adjust the path to your repo location.

```

Alias /movie-scanner /path/to/qr-code-movie-scanner/web
<Directory /path/to/qr-code-movie-scanner/web>
       Options Indexes
       Require all granted
       DirectoryIndex index.php
</Directory>
```

Afterwards restart Apache again with `systemctl restart apache2`.

4. Adjust the config file

Copy the `config.php.sample` file to `web/config.php` and edit the contents. Descriptions for the config settings are:

```
$DEBUG_MODE = false;  // prints debug information and does not play video on Kodi when code scanned. Enable for testing.

// Kodi information
$KODI_ADDRESS = "localhost"; // the IP address of your Kodi player
$KODI_PORT = "8080"; // port the Kodi JSON server is running on

// QR Code Generation
$QR_BASE_URL = "http://localhost/index.php"; // the base url to the `index.php` script. This is used as the base url for the QR code generation
$SECURITY_CODE = "1234"; // an additional code appended to all generated QR codes (sha256 hash of this + movie title). This is checked when scanning and must match for playback to trigger.
$TOTAL_COLS = 4;  // how many columns for the QR code table
$QR_SIZE = 125;  // size of the generated QR code, in pixels

// Playback settings
$OVERRIDE_PLAYING = false;  //controls if scan will override currently playing Kodi content
```

_Notes on the security code:_ The idea behind this was to add a way to avoid abuse since the URLs are pretty easy to generate. Anyone could easily load up a browser and trigger playback maliciously. The security code is a quick check that it's a valid query. Once you've generated QR codes and affixed them do not change this value or all QR codes will stop working.

## Usage

### Creating QR Codes

To create a QR code load the `generator.php` script. When configured properly this will query your Kodi instances and show two boxes. All movies listed in the top box exist in your Kodi media center. Select the titles you want to generate QR codes for and click "Add" to add them to the bottom box. You can also remove titles by selecting them in the lower box and clicking "Remove". When you have all the titles selected click the Generate button.

On the codes page you should see a grid of QR codes along with the title of the movie. In debug mode you'll also see the link embedded in the QR code below the title. This is helpful when testing that your codes will work properly prior to printing anything. The size and layout of the codes can be controlled with the `TOTAL_COLS` and `QR_SIZE` variables. Links are generated in the format `{$QR_BASE_URL}?security={$SECURITY_CODE}&title={MOVIE_TITLE}&year={MOVIE_YEAR}`.

__Example__
```
// settings in config.php

$QR_BASE_URL = "http://192.168.1.100/movie-scanner/index.php"  // path to index.php script
$SECURITY_CODE = "1234"

```

Assuming a movie title of __Inception__ the generated URL for that title would be: `http://192.168.1.100/movie-scanner/index.php?security=4fe686b94ac81e745e13a5fe75e9dc06bce3ffac5448e02f4a7c1b616fb413b9&title=Inception&year=2010`.

### Using QR Codes

Scanning a QR Code will launch the `index.php` script. This script will perform the following tasks, in order.

1. Check the `security` query parameter. If this fails the script displays a blank page and does nothing.
2. Query Kodi using the given `title` and `year` query parameter. This checks that the title still exists and returns some information about it.
3. Confirms Kodi is not currently playing something (unless the override variable above is set to true). If Kodi is playing a message is shown stating playback cannot be started.
4. Finally, playback of the movie is executed on the media center.

When the `DEBUG_MODE` variable is set to true step #4 is not executed. Additionally the Kodi JSON-RPC calls are displayed along with their responses.

## Thanks

Special thanks and call out to [@psyon](https://github.com/psyon) and the [PHP QR Code library](https://github.com/psyon/php-qrcode) used to generate the images.

## License

[GPLv3](https://github.com/robweber/qr-code-movie-scanner/blob/main/LICENSE)
