## Requirements:

1. [Node.js](https://nodejs.org/)
2. [Gulp.js](http://gulpjs.com/)

## Installation

Put `WP-Theme` folder into your themes directory. 

Copy `package.json`and `gulpfile.js`into WordPress root. 

Run

```shell
npm install
```

to install all gulp plugins.

If you don't want to have `package.json` and `gulpfile.js` in root directory you can leave them in the theme, and run `npm install` in theme directory. But in that case be sure to change the paths in `gulpfile.js`. You will mostly have to delete `/wp-content/themes/wp-theme/` from the paths.

When you are done just run `gulp watch`
