# UltraCMS
Simple CMS/Framework Application Manager

[See this README in pt_BR](https://github.com/in9web/ultracms/blob/master/README_pt_BR.md) ![pt_BR Flag](http://flagpedia.net/data/flags/mini/br.png)

# Preview theme "default"
This theme with translaction working in pt_BR (portuguese)
![UltraCMS theme default preview](https://i.imgur.com/PtUxHxk.jpg)

# Features

- Whitelabel;
- Command line creations;
- Front-End free create;
- Admin creator similar to Cake Bake (CakePHP) or Scafolding (Ruby on Rails);
- Modular admin;
- Support database migrations;
- Admin themes;
- Admin authentication;
- Configurable with .env, change everything without problems;
  - Enviroument not required change your .env and 'voulá';
- Support Logs;
- Translations;
- Open Source;

# Installation

In future we you add on packagist. for now clone this repo with:

```git clone https://github.com/in9web/ultracms.git```

after cloned repository install dependencies with composer, doing this:

```composer install```

after this you can change configurations and basic commands to create your first module, like:

```./ultra make:module Pages``` this will create folder in your admin folder with basic crud to pages model.

# Configuration

You can change the file ```.env```in this folder or change ```config.php``` in this folder to add more configs.
Remember this CMS is whitelabel you can change this on config.php file.

# Documentation

## Get Started

## Tutorial

## API

# Contributing

Thank you for considering contributing to the UltraCMS. 
You have a problem open a issue in https://github.com/in9web/ultracms/issues

# Changelog

0.1.0 - Beta Version Released, basic usage. Upload file not working.

# Tasks/Todo List

- Create a Logo to UltraCMS;
- Add support to FileUpload;
- Add command to remove module;
- Create documentation to GetStarted;
- Create video tutorial to usage UltraCMS pt_BR after en_US;
- Add assets to ColorBox;
- Create theme admin using AdminLTE;
- Create feature Widgets to modules, to external usage from module;
- Add support to API using PHPCrudAPI (https://github.com/mevdschee/php-crud-api)
- Add better support to logs;
- Add better support to migrations in modules;
- Add better support to models in modules;
- Add core translation to Spanish;
- 
# Licence

This work is licensed under a [MIT License](https://github.com/in9web/ultracms/blob/master/LICENSE)
