<?php

use Uninett\Auth\Dataporten\Listener;
use Illuminate\Contracts\Events\Dispatcher;

return function (Dispatcher $events) {
    $events->subscribe(Listener\AddClientAssets::class);
    $events->subscribe(Listener\AddDataportenAuthRoute::class);
};
