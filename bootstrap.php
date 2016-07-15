<?php

	use Illuminate\Contracts\Events\Dispatcher;
	use Uninett\Auth\Dataporten\Listener;

	return function (Dispatcher $events) {
		$events->subscribe(Listener\AddClientAssets::class);
		$events->subscribe(Listener\AddDataportenAuthRoute::class);
	};
