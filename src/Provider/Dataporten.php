<?php


	namespace Uninett\Auth\Dataporten\Provider;

	use League\OAuth2\Client\Token\AccessToken;
	use League\OAuth2\Client\Provider\AbstractProvider;
	use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
	use Psr\Http\Message\ResponseInterface;
	use Uninett\Auth\Dataporten\Provider\Exception\DataportenIdentityProviderException;

	class Dataporten extends AbstractProvider {
		use BearerAuthorizationTrait;

		/**
		 * Domain
		 *
		 * @var string
		 */
		public $domain = 'https://auth.dataporten.no';

		/**
		 * API
		 *
		 * @var string
		 */
		public $api = 'https://api.dataporten.no';

		/**
		 * Get authorization url to begin OAuth flow
		 *
		 * @return string
		 */
		public function getBaseAuthorizationUrl() {
			return $this->domain . '/oauth/authorization';
		}

		/**
		 * Get access token url to retrieve token
		 *
		 * @param  array $params
		 *
		 * @return string
		 */
		public function getBaseAccessTokenUrl(array $params) {
			return $this->domain . '/oauth/token';
		}

		/**
		 * Get provider url to fetch user details
		 *
		 * @param  AccessToken $token
		 *
		 * @return string
		 */
		public function getResourceOwnerDetailsUrl(AccessToken $token) {
			return $this->domain . '/userinfo';
		}

		/**
		 * Get the default scopes used by this provider.
		 *
		 * This should not be a complete list of all scopes, but the minimum
		 * required for the provider user interface!
		 *
		 * @return array
		 */
		protected function getDefaultScopes() {
			return [];
		}

		/**
		 * Check a provider response for errors.
		 *
		 * @link   https://developer.github.com/v3/#client-errors
		 * @link   https://developer.github.com/v3/oauth/#common-errors-for-the-access-token-request
		 *
		 * @param  ResponseInterface $response
		 * @param  string            $data Parsed response data
		 *
		 * @throws \League\OAuth2\Client\Provider\Exception\IdentityProviderException
		 */
		protected function checkResponse(ResponseInterface $response, $data) {
			if($response->getStatusCode() >= 400) {
				throw DataportenIdentityProviderException::clientException($response, $data);
			} elseif(isset($data['error'])) {
				throw DataportenIdentityProviderException::oauthException($response, $data);
			}
		}

		/**
		 * Generate a user object from a successful user details request.
		 *
		 * @param array       $response
		 * @param AccessToken $token
		 *
		 * @return ResourceOwner
		 */
		protected function createResourceOwner(array $response, AccessToken $token) {
			$user = new DataportenResourceOwner($response);

			return $user->setDomain($this->domain, $this->api);
		}
	}
