<?php

namespace Uninett\Auth\Dataporten\Listener;

use Flarum\Event\ConfigureClientView;
use Illuminate\Contracts\Events\Dispatcher;

class AddClientAssets
{
    /**
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen(ConfigureClientView::class, [$this, 'addAssets']);
    }

    /**
     * @param ConfigureClientView $event
     */
    public function addAssets(ConfigureClientView $event)
    {
        if ($event->isForum()) {
            $event->addAssets([
                __DIR__.'/../../js/forum/dist/extension.js',
                __DIR__.'/../../less/forum/extension.less'
            ]);
            $event->addBootstrapper('uninett/auth-dataporten/main');
        }

        if ($event->isAdmin()) {
            $event->addAssets([
                __DIR__.'/../../js/admin/dist/extension.js'
            ]);
            $event->addBootstrapper('uninett/auth-dataporten/main');
        }
    }
}
