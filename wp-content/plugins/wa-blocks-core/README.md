# WP Block Starter

Author: Chris Opstrup &lt;ckjaersig@gmail.com&gt;

This repository was created as part of a post I did on developing blocks for the Wordpress block editor. The post can be found [here](https://ckjaersig.dk/2022/09/getting-started-with-wordpress-block-development/): 

## Getting started

1. Install dependencies: `npm install`
2. Generate a new block: 
```bash
cd src/blocks
npx @wordpress/create-block --no-plugin --no-wp-scripts --title "<your title>" --namespace wp-block-starter "<your-block-name>"
```
3. Build and watch source files: `npm run dev`
4. Remember to register new blocks in `wp_block_starter.php`

Source files are found in the `src` folder and built files are found in the `build` folder.

This project uses `@wordpress/scripts` for compilation of blocks, which requires blocks to be in the `src` folder, the `blocks` folder is something I added in case I want other files that are not related to blocks as source files.