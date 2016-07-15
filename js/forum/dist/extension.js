'use strict';

System.register('uninett/auth-dataporten/main', ['flarum/extend', 'flarum/app', 'flarum/components/LogInButtons', 'flarum/components/LogInButton'], function (_export, _context) {
	"use strict";

	var extend, app, LogInButtons, LogInButton;
	return {
		setters: [function (_flarumExtend) {
			extend = _flarumExtend.extend;
		}, function (_flarumApp) {
			app = _flarumApp.default;
		}, function (_flarumComponentsLogInButtons) {
			LogInButtons = _flarumComponentsLogInButtons.default;
		}, function (_flarumComponentsLogInButton) {
			LogInButton = _flarumComponentsLogInButton.default;
		}],
		execute: function () {

			app.initializers.add('uninett/auth-dataporten', function () {
				extend(LogInButtons.prototype, 'items', function (items) {
					items.add('dataporten', m(
						LogInButton,
						{
							className: 'Button LogInButton--dataporten',
							icon: 'unlock',
							path: '/auth/dataporten'
						},
						app.translator.trans('uninett-auth-dataporten.forum.log_in.with_dataporten_button')
					));
				});
			});
		}
	};
});