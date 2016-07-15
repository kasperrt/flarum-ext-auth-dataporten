'use strict';

System.register('uninett/auth-dataporten/components/DataportenSettingsModal', ['flarum/components/SettingsModal', 'flarum/app'], function (_export, _context) {
	"use strict";

	var SettingsModal, app, DataportenSettingsModal;
	return {
		setters: [function (_flarumComponentsSettingsModal) {
			SettingsModal = _flarumComponentsSettingsModal.default;
		}, function (_flarumApp) {
			app = _flarumApp.default;
		}],
		execute: function () {
			DataportenSettingsModal = function (_SettingsModal) {
				babelHelpers.inherits(DataportenSettingsModal, _SettingsModal);

				function DataportenSettingsModal() {
					babelHelpers.classCallCheck(this, DataportenSettingsModal);
					return babelHelpers.possibleConstructorReturn(this, Object.getPrototypeOf(DataportenSettingsModal).apply(this, arguments));
				}

				babelHelpers.createClass(DataportenSettingsModal, [{
					key: 'className',
					value: function className() {
						return 'DataportenSettingsModal Modal--small';
					}
				}, {
					key: 'title',
					value: function title() {
						return app.translator.trans('uninett-auth-dataporten.admin.dataporten_settings.title');
					}
				}, {
					key: 'form',
					value: function form() {
						return [m(
							'div',
							{className: 'Form-group'},
							m(
								'label',
								null,
								app.translator.trans('uninett-auth-dataporten.admin.dataporten_settings.client_id_label')
							),
							m('input', {
								className: 'FormControl',
								bidi: this.setting('uninett-auth-dataporten.client_id')
							})
						), m(
							'div',
							{className: 'Form-group'},
							m(
								'label',
								null,
								app.translator.trans('uninett-auth-dataporten.admin.dataporten_settings.client_secret_label')
							),
							m('input', {
								className: 'FormControl',
								bidi: this.setting('uninett-auth-dataporten.client_secret')
							})
						)];
					}
				}]);
				return DataportenSettingsModal;
			}(SettingsModal);

			_export('default', DataportenSettingsModal);
		}
	};
});
;
'use strict';

System.register('uninett/auth-dataporten/main', ['flarum/extend', 'flarum/app', 'uninett/auth-dataporten/components/DataportenSettingsModal'], function (_export, _context) {
	"use strict";

	var extend, app, DataportenSettingsModal;
	return {
		setters: [function (_flarumExtend) {
			extend = _flarumExtend.extend;
		}, function (_flarumApp) {
			app = _flarumApp.default;
		}, function (_uninettAuthDataportenComponentsDataportenSettingsModal) {
			DataportenSettingsModal = _uninettAuthDataportenComponentsDataportenSettingsModal.default;
		}],
		execute: function () {

			app.initializers.add('uninett/auth-dataporten', function (app) {
				app.extensionSettings['uninett-auth-dataporten'] = function () {
					return app.modal.show(new DataportenSettingsModal());
				};
			});
		}
	};
});