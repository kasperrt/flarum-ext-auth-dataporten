import { extend } from 'flarum/extend';
import app from 'flarum/app';
import LogInButtons from 'flarum/components/LogInButtons';
import LogInButton from 'flarum/components/LogInButton';

app.initializers.add('uninett/auth-dataporten', () => {
  extend(LogInButtons.prototype, 'items', function(items) {
    items.add('dataporten',
      <LogInButton
        className="Button LogInButton--dataporten"
        icon="unlock"
        path="/auth/dataporten">
        {app.translator.trans('uninett-auth-dataporten.forum.log_in.with_dataporten_button')}
      </LogInButton>
    );
  });
});
