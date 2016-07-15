import {extend} from "flarum/extend";
import app from "flarum/app";
import DataportenSettingsModal from "uninett/auth-dataporten/components/DataportenSettingsModal";

app.initializers.add('uninett/auth-dataporten', app => {
	app.extensionSettings['uninett-auth-dataporten'] = () => app.modal.show(new DataportenSettingsModal());
});