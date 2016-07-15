<?php

namespace Uninett\Auth\Dataporten;

use Flarum\Forum\AuthenticationResponseFactory;
use Flarum\Forum\Controller\AbstractOAuth2Controller;
use Flarum\Settings\SettingsRepositoryInterface;
use League\OAuth2\Client\Provider\GenericProvider;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class DataportenAuthController extends AbstractOAuth2Controller
{
    /**
     * @var SettingsRepositoryInterface
     */
    protected $settings;

    /**
     * @param AuthenticationResponseFactory $authResponse
     * @param SettingsRepositoryInterface $settings
     */
    public function __construct(AuthenticationResponseFactory $authResponse, SettingsRepositoryInterface $settings)
    {
        $this->settings = $settings;
        $this->authResponse = $authResponse;
    }

    /**
     * {@inheritdoc}
     */
    protected function getProvider($redirectUri)
    {
        return new GenericProvider ([
            'clientId'        => $this->settings->get('uninett-auth-dataporten.app_id'),
            'clientSecret'    => $this->settings->get('uninett-auth-dataporten.app_secret'),
            'redirectUri'     => $redirectUri,
            'approvalPrompt'  => 'force',
            'hostedDomain'    => $this->settings->get('uninett-auth-dataporten.app_domain'),
            'accessType'      => 'offline'
        ]);
    }

    /**
     * {@inheritdoc}
     *
     * TODO: Check DATAPORTEN USERINFO!
     */
    protected function getAuthorizationUrlOptions()
    {
        return [
            'scope' =>
                [
                    'email',
                    'profile',
                    'https://auth.dataporten.no/userinfo'
                ]
        ];    }

    /**
     * {@inheritdoc}
     */
    protected function getIdentification(ResourceOwnerInterface $resourceOwner)
    {
        return [
            'email' => $resourceOwner->getEmail()
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getSuggestions(ResourceOwnerInterface $resourceOwner)
    {
        return [
            'username' => $resourceOwner->getFirstName(),
        ];
    }
}
