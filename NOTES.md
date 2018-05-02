# @Fork Notes &mdash; *tonik-child-theme*

> The following is the short list of additional items and small changes made to the original [tonik/child-theme](https://github.com/tonik/child-theme/tree/master). They're meant to work in conjuction with our [custom parent theme](https://github.com/sushidub/tonik-theme). One key addition is the porting over and repurposing of build tasks directly from parent theme [as suggested by tonik team](http://labs.tonik.pl/theme/docs/child-theme-development/). We also symlink to the parent node_modules folder.

## `/`
+ symlink to [tonik-theme](https://github.com/sushidub/tonik-theme) `node-modules`
+ duplicate `build` folder and contents from parent

`- composer.json`
+ add [`stoutlogic/acf-builder`](https://github.com/StoutLogic/acf-builder) as an addition to ACF Pro - *this is optional*

`- package.json`
+ duplicate parent theme build tasks
+ adds custom task for more debugging options
+ adds `development` only plugin for [visualizing webpack details](https://github.com/chrisbateman/webpack-visualizer)

`- style.css`
+ replace whatever value the `Template:` string has with the name of the parent theme (WP uses this to cordinate parent/child theme relationship)
+ we're updating the `Text Domain:` string so we also update the `textdomain` value in `/Config - app.php`

## `build`
`/rules - javascript.js`
+ add the following to module.exports obj, otherwise running build tasks with certian flags will output eslint warnings/errors it finds in node_modules folder
```js
exclude: /node_modules/,
```

`- app.config.js`
+ no changes for this branch

`- webpack.config.js`
+ require the webpack visualizer plugin we installed in package.json
```js
const Visualizer = require('webpack-visualizer-plugin');
```
+ `devtool` property change: `source-map` to `inline-cheap-module-source-map`
+ add a `target` property:
```js
target: 'web',
```
+ `output` property, add the following property:
```js
pathinfo: true
```
+ change the `performance` property value to the string: `'warning'`
+ add the following as a `stats` property:
```js
  stats: {
    errors: true,
    errorDetails: true
  },
  ```
  + add the following to the `plugins` array:
  ```js
      new Visualizer()
  ```
  ## `config`
  + add an `app.json` file (same structure as parent)

  `- app.json`
  ```json
  {
    "assets": {
      "main": [
        "./resources/assets/js/main.js",
        "./resources/assets/sass/main.scss"
      ]
    }
  }
```

  ## `resources`
  + add an `assets` folder (same structure as parent theme)

  `/assets`
  + add the main `sass` folder (will contain all of our scss files)
  + add a `js` folder

  `/assets/js`
  + add `main.js` and then add the self-invoking alternative to `import...from` statement:
  ```js
  (function ( $ ) {
    // ...code...
  })( jQuery );
  ```

  `/assets/sass`
  + add `main.scss` which will contain all of our `.scss` `@import` statements

  `/assets/sass - main.scss`
  + import normalize.scss since we're not using any of the other framework options that have it included, e.g. Foundation, Bootstrap.
  ```scss
  @import '~normalize-scss/sass/normalize/import-now';
  ```

  ## `child`
  `/** -`
  #### *Optional namespacing safeguards for paths, hooks, & filters*
  + change any `namespace` values to follow the parent convention:

  ```php
  // from this
  namespace App\Theme\Child\Http;
  // to this
  namespace Tonik\Theme\Child\Http;
  ```
  + use PHP `__NAMESPACE__` constant in path hooks and filters:

  ```php
  namespace Tonik\Theme\App\Setup;

  function render_sidebar()
  {
    get_sidebar();
  }
  add_action('theme/index/sidebar', __NAMESPACE__ . '\\render_sidebar');
  ```
  `/Http - assets.php`
  + add the `register_wp_scripts` and `register_scripts` functions *(see file for additional notes)*
