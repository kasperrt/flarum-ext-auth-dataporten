# Flarum Dataporten Authentication Extension

Allows users to login using Dataporten from UNINETT.

## Usage

### 1. Install Flarum as per [my release notes] (https://github.com/skrodal/flarum-ext-auth-dataporten/releases/tag/v0.1.0-beta.5.0).


### 2. Register your client with Dataporten

1. Register your client at https://dashboard.dataporten.no/. 
    - The redirect URI should look like this: `https://domain.no/[path_to_flarum]/auth/dataporten`)
2. Request the following scopes (rettigheter): `email`, `profile` (for name and photo) and `userid-feide`
3. Make a note of the OAuth Client credentials (`Client ID` and `Client Secret`)

### 3. Install this extenstion

1. Install the extension with Composer (`composer require uninett/flarum-ext-auth-dataporten`)
2. Enable the extension in Flarum's admin/extensions page
3. Fill in the OAuth Client credentials (`Client ID` and `Client Secret`) in the settings for the extension

## Other requirements

```
    "require": {
        "flarum/core": "^0.1.0-beta.5",
        "league/oauth2-client": "~1.0"
    },
```

- The PHP League OAuth 2.0 Client: https://github.com/thephpleague/oauth2-client
