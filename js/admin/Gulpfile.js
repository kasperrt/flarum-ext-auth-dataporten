var gulp = require('flarum-gulp');

gulp({
  modules: {
    'uninett/auth-dataporten': [
      'src/**/*.js'
    ]
  }
});
