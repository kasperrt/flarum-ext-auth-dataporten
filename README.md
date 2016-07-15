** This repo is under development! **

# Flarum Dataporten Authenticator

Allows users to login using Dataporten from UNINETT AS.

## Installation

To install, use composer:

```
composer require uninett/flarum-ext-auth-dataporten
```

## Usage

* Install extension via Composer
* Enable extension in the admin/extensions of Flarum
* Fill in the settings field for the extension

### Setting up Dataporten

Your application will require a *Client ID* and *Client Secret*. Get these from 

https://dashboard.dataporten.no/

## Credits

This is a rewrite of the Google Authenticator extension for Flarum: https://github.com/johnhearfield/flarum-ext-oauth-google