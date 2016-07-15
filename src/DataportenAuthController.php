<?php

	namespace Uninett\Auth\Dataporten;

	use Flarum\Forum\AuthenticationResponseFactory;
	use Flarum\Forum\Controller\AbstractOAuth2Controller;
	use Flarum\Settings\SettingsRepositoryInterface;
	use League\OAuth2\Client\Provider\ResourceOwnerInterface;
	use Uninett\Auth\Dataporten\Provider\Dataporten;

	class DataportenAuthController extends AbstractOAuth2Controller {
		/**
		 * @var SettingsRepositoryInterface
		 */
		protected $settings;

		/**
		 * @param AuthenticationResponseFactory $authResponse
		 * @param SettingsRepositoryInterface   $settings
		 */
		public function __construct(AuthenticationResponseFactory $authResponse, SettingsRepositoryInterface $settings) {
			$this->settings     = $settings;
			$this->authResponse = $authResponse;
		}

		/**
		 * {@inheritdoc}
		 */
		protected function getProvider($redirectUri) {
			return new Dataporten ([
				'clientId'                => $this->settings->get('uninett-auth-dataporten.client_id'),
				'clientSecret'            => $this->settings->get('uninett-auth-dataporten.client_secret'),
				'redirectUri'             => $redirectUri,
				'urlAuthorize'            => 'https://auth.dataporten.no/oauth/authorization',
				'urlAccessToken'          => 'https://auth.dataporten.no/oauth/token',
				'urlResourceOwnerDetails' => 'https://auth.dataporten.no/userinfo'
			]);
		}

		/**
		 * {@inheritdoc}
		 */
		protected function getAuthorizationUrlOptions() {
			return [];
		}

		/**
		 * {@inheritdoc}
		 */
		protected function getIdentification(ResourceOwnerInterface $resourceOwner) {
			return [
				'email' => $resourceOwner->getEmail()
			];
		}

		/**
		 * {@inheritdoc}
		 */
		protected function getSuggestions(ResourceOwnerInterface $resourceOwner) {
			return [
				'username'  => $resourceOwner->getUserName(),
				'avatarUrl' => $resourceOwner->getProfilePhoto()
			];
		}
	}
