# Thumbnail Processor for Shopware 5

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

This plugin allows you to use variable thumbnails, if your filesystem (or storage-adapter) supports.
It will add parameters to original image paths.
So you are able to save storage and add new thumbnails on the fly.

## Install

Download the plugin from the release page and enable it in shopware.

## Usage
You can activate using of Thumbnail Processor in plugin. Clear all caches after changing settings.
This will access all thumbnails variable from original image. The thumbnail-files won't be needed anymore.

````
f.e.:
https://cdn.example.de/media/image/01/82/69/sasse_200x200.png
 becomes:
https://cdn.example.de/media/image/52/5b/a1/sasse.png?width=200&height=200
````
You can edit the thumbnail-template within the plugin-config. Defaults `{mediaUrl}/{mediaPath}?width={width}&height={height}`.
Available variables with examples:
* {mediaUrl}: https://cdn.test.de/
* {mediaPath}: media/image/5b/6d/16/tea.png
* {width}: 800
* {height}: 800

### Removing unneeded thumbnails
To remove all thumbnails use following command. This will collect and remove all thumbnails related to the media manager:
`bin/console frosh:thumbnails:remove`

## Tested Supports

### imgproxy [Link](https://imgproxy.net/)

Tested with insecure environment for internal test-shops. Template example: `http://localhost:8080/insecure/fit/{width}/{height}/sm/0/plain/{mediaUrl}/{mediaPath}`.

### BunnyCDN [Link](https://bunnycdn.com/)

You would have to active `Bunny Optimizer` and `Manipulation Engine` in your Zone in BunnyCDN.

![Activate Manipulation Engine](Resources/store/docs/images/bunnycdn_1.jpg)

### Images.weserv.nl [Link](https://images.weserv.nl/)

An image cache & resize service. Manipulate images on-the-fly with a worldwide cache. Template example: `https://images.weserv.nl/?url={mediaUrl}/{mediaPath}&w={width}&h={height}`.

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
