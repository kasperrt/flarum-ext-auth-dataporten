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

## Other

- Makes use of the OAuth 2.0 Client https://github.com/thephpleague/oauth2-client
