<?php

	namespace Uninett\Auth\Dataporten\Provider;

	use League\OAuth2\Client\Provider\ResourceOwnerInterface;

	class DataportenResourceOwner implements ResourceOwnerInterface {
		/**
		 * Domain
		 *
		 * @var string
		 */
		protected $domain;

		/**
		 * API
		 *
		 * @var string
		 */
		protected $api;


		/**
		 * Raw response
		 *
		 * @var array
		 */
		protected $response;

		/**
		 * Creates new resource owner.
		 *
		 * @param array $response
		 */
		public function __construct(array $response = array()) {
			$this->response = $response;
		}

		/**
		 * Get resource owner id
		 *
		 * @return string|null
		 */
		public function getId() {
			return $this->response['user']['userid'] ?: NULL;
		}

		/**
		 * userid-feide or first name or null.
		 *
		 * @return string|null
		 */
		public function getFeideUserName() {
			return $this->getUserIdFeide() ?: $this->getFirstName();;
		}

		/**
		 * Get resource owner userid-feide (e.g. "userid_sec":["feide:user@org.no"])
		 *
		 * @return string|null
		 */
		public function getUserIdFeide() {
			$userName = NULL;

			if(sizeof($this->response['user']['userid_sec']) > 0) {
				foreach($this->response['user']['userid_sec'] as $userId) {
					if(str_contains($userId, 'feide:')) {
						$userId   = explode(':', $userId);
						$userName = $userId[1];
						break;
					}
				}
			}

			return $userName;
		}

		public function getFirstName() {
			if(!is_null($this->getName())) {
				$firstName = explode(' ', $this->getName());

				return $firstName[0];
			}

			return NULL;
		}

		/**
		 * Get resource owner name
		 *
		 * @return string|null
		 */
		public function getName() {
			return $this->response['user']['name'] ?: NULL;
		}

		/**
		 * Suggested username in Flarum
		 *
		 * @return mixed|null|string
		 */
		public function getUserName() {
			// Flarum does not like any international/special characters (inc. spaces, dots and '@'s) in the username...
			$unwanted_chars = array('Š' => 'S', 'š' => 's', 'Ž' => 'Z', 'ž' => 'z', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E',
			                        'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U',
			                        'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'a', 'ç' => 'c',
			                        'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o',
			                        'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'þ' => 'b', 'ÿ' => 'y', ' ' => '-', '@' => '-', '.' => '-');

			// Prefer full name
			if(!is_null($this->getName())) {
				return strtolower(strtr($this->getName(), $unwanted_chars));
			}
			// ...if not, Feide username
			if(!is_null($this->getUserIdFeide())) {
				return strtolower(strtr($this->getUserIdFeide(), $unwanted_chars));
			}
			// ...hm, what about email then?
			if(!is_null($this->getEmail())) {
				return strtolower(strtr($this->getEmail(), $unwanted_chars));
			}

			// Give up on suggestions
			return NULL;

		}

		/**
		 * Get resource owner email
		 *
		 * @return string|null
		 */
		public function getEmail() {
			return $this->response['user']['email'] ?: NULL;
		}

		public function getProfilePhoto() {
			return $this->api . '/userinfo/v1/user/media/' . $this->response['user']['profilephoto'] ?: NULL;
		}

		/**
		 * Get resource owner url
		 *
		 * @return string|null
		 */
		/*
		public function getUrl() {
			return trim($this->domain . '/' . $this->getNickname()) ?: NULL;
		}
		*/

		/**
		 * Get resource owner nickname
		 *
		 * @return string|null
		 */

		/*
		public function getNickname() {
			return $this->getUserName();
		}
		*/

		/**
		 * Set resource owner domain
		 *
		 * @param  string $domain
		 *
		 * @return ResourceOwner
		 */
		public function setDomain($domain, $api) {
			$this->domain = $domain;
			$this->api    = $api;

			return $this;
		}

		/**
		 * Return all of the owner details available as an array.
		 *
		 * @return array
		 */
		public function toArray() {
			return $this->response;
		}
	}
