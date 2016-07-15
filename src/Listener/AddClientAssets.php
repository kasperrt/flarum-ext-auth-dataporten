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

	/**
	 * Provides i18n files.
	 *
	 * @param ConfigureLocales $event
	 */
	public function addLocales(ConfigureLocales $event)
	{
		foreach (new DirectoryIterator(__DIR__.'/../../locale') as $file) {
			if ($file->isFile() && in_array($file->getExtension(), ['yml', 'yaml'])) {
				$event->locales->addTranslations($file->getBasename('.'.$file->getExtension()), $file->getPathname());
			}
		}
	}
}
