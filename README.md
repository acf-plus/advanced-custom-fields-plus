# [Advanced Custom Fields Plus](https://acf.plus)
[![Packagist](https://img.shields.io/packagist/vpre/acf-plus/advanced-custom-fields-plus.svg?style=flat-square)](https://packagist.org/packages/acf-plus/advanced-custom-fields-plus)
[![devDependency Status](https://img.shields.io/david/dev/acf-plus/advanced-custom-fields-plus.svg?style=flat-square)](https://david-dm.org/acf-plus/advanced-custom-fields-plus#info=devDependencies)
[![Build Status](https://img.shields.io/travis/acf-plus/advanced-custom-fields-plus.svg?style=flat-square)](https://travis-ci.org/acf-plus/advanced-custom-fields-plus)

=== Advanced Custom Fields Plus ===

A custom ACF plugin boilerplate.

== Setup ==

This plugin uses namespaces following format:
CompanyName\PluginName\Folder 

It starts with namespace ACF\ACFPLUS autoloading the lib folder;

Before composer install -> do a find and replace in all folders for ACFPLUS.  Replace with your plugin name.

== Commands ==

To Bootstrap:

1. composer install
2. yarn
3. yarn run watch


All Commands:

composer install
composer dump-autoload
yarn
yarn run dev
yarn run watch
yarn run production
