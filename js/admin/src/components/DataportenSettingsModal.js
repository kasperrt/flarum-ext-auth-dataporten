import SettingsModal from 'flarum/components/SettingsModal';
import app from 'flarum/app';

export default class DataportenSettingsModal extends SettingsModal {
  className() {
    return 'DataportenSettingsModal Modal--small';
  }

  title() {
    return app.translator.trans('uninett-auth-dataporten.admin.dataporten_settings.title');
  }

  form() {
    return [
      <div className="Form-group">
        <label>{app.translator.trans('uninett-auth-dataporten.admin.dataporten_settings.client_id_label')}</label>
        <input className="FormControl" bidi={this.setting('uninett-auth-dataporten.app_id')}/>
      </div>,

      <div className="Form-group">
        <label>{app.translator.trans('uninett-auth-dataporten.admin.dataporten_settings.client_secret_label')}</label>
        <input className="FormControl" bidi={this.setting('uninett-auth-dataporten.app_secret')}/>
      </div>,

      <div className="Form-group">
        <label>{app.translator.trans('uninett-auth-dataporten.admin.dataporten_settings.hosted_domain_label')}</label>
        <input className="FormControl" bidi={this.setting('uninett-auth-dataporten.app_domain')}/>
      </div>
    ];
  }
}
