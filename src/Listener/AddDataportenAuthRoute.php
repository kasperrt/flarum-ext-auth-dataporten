<?php

	namespace Uninett\Auth\Dataporten\Listener;

	use Flarum\Event\ConfigureForumRoutes;
	use Illuminate\Contracts\Events\Dispatcher;

	class AddDataportenAuthRoute {
		/**
		 * @param Dispatcher $events
		 */
		public function subscribe(Dispatcher $events) {
			$events->listen(ConfigureForumRoutes::class, [$this, 'configureForumRoutes']);
		}

		/**
		 * @param ConfigureForumRoutes $event
		 */
		public function configureForumRoutes(ConfigureForumRoutes $event) {
			$event->get('/auth/dataporten', 'auth.dataporten', 'Uninett\Auth\Dataporten\DataportenAuthController');
		}
	}
