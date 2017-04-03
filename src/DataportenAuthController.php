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

		protected function getGroupFromApi($user_email) {
				$url = 'https://groups-api.dataporten.no/groups/me/groups';
				$groups = $this->provider->getResponse(
						$this->provider->getAuthenticatedRequest('GET', $url, $this->token)
				);
				$group_ids = Array();
				foreach($groups as $group) {
					$get_group = Group::where('name_singular', $group["displayName"] . $group["id"])->get();
					if(count($get_group) == 0) {
						$code = dechex(crc32($group["displayName"]));
						$code = "#" . substr($code, 0, 6);
						$new_group = Group::build(
		            $group["displayName"] . $group["id"],
    				    $group["displayName"] . $group["id"],
    				    $code,
    				    null
    				);
    				$new_group->save();
						$permission = Permission::where('permission', 'discussion.likePosts')->get();
						$group_id = $new_group["attributes"]["id"];
						$permissions = ["discussion.flagPosts", "discussion.likePosts", "discussion.reply", "discussion.replyWithoutApproval", "discussion.startWithoutApproval", "startDiscussion"];
						foreach($permissions as $permission) {
							Permission::insert(Array('permission' => $permission, 'group_id' => $group_id));
						}
					} else {
						$group_id = $get_group[0]["attributes"]["id"];
					}
					array_push($group_ids, $group_id);
				}
				$user = User::where('email', $user_email)->get();
				$user[0]->groups()->sync($group_ids);
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
