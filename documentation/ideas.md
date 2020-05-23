# Ideas

This document is filled with ideas around the following:
- Things to transform into examples.
- Things to write documentation about.
- Things to turn into sharable content.

## Choose Your Path: Namespacing your Code
Information about the following namespacing patterns:

add_action( 'init', 'wholesomecode_wholesome_examples_my_function', 10 );
add_action( 'init', [ $this, 'my_function' ], 10 ); // (Inside a Class).
add_action( 'init', __NAMESPACE__ . '\\my_function', 10 );

- [ ] Tweet
- [ ] Infographic
- [ ] Video
- [ ] Blog Post

Also need to talk about code structure, and reasons why choices were made.

## Getting Data into Gutenberg

Information about the following patterns:

1. Select from Core - https://wholesomecode.ltd/articles/wp_query-and-the-wordpress-block-editor-gutenberg/

2. wp_localize_script - see /inc/namespace.php for settings, and /src/settings.php.

3. Data Store - https://wholesomecode.ltd/articles/using-the-wordpress-block-editor-gutenberg-with-the-rest-api, usful if we are going to transform the state of something such as an option.

- [ ] Tweet
- [ ] Infographic
- [ ] Video
- [ ] Blog Post

## How to Comment in your package.json

See package.json, and the techniques used.

- [ ] Tweet
- [ ] Infographic
- [ ] Video
- [ ] Blog Post

## How to load your block assets.

Look at /documentation/alternatives/enqueue-block-assets.php and talk about when you should use each method.

- [ ] Tweet
- [ ] Infographic
- [ ] Video
- [ ] Blog Post