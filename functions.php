<?php
/**
 * Blog functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Blog
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function blog_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Blog, use a find and replace
		* to change 'blog' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'blog', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'blog' ),
			'menu-2' => esc_html__( 'Header', 'blog' ),
			'menu-3' => esc_html__( 'Social', 'blog' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'blog_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'blog_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function blog_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'blog_content_width', 640 );
}
add_action( 'after_setup_theme', 'blog_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function blog_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'blog' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'blog' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'blog_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function blog_scripts() {
	wp_enqueue_style( 'blog-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_enqueue_style( 'blog-theme-3', get_template_directory_uri() . '/assets/css/theme-3.css', array(), _S_VERSION );
	//wp_style_add_data( 'blog-style', 'rtl', 'replace' );

	wp_enqueue_script( 'blog-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'blog_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

// свой класс построения меню:
class Custom_Menu extends Walker_Nav_Menu {
	private string $nav_item;
	private string $nav_link;

	public function __construct(string $nav_item, string $nav_link)
	{
			$this->nav_item = $nav_item;
			$this->nav_link = $nav_link;
	}	

	// add classes to ul sub-menus
	function start_lvl( &$output, $depth = 0, $args = NULL ) {
		// depth dependent classes
		$indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
		$display_depth = ( $depth + 1); // because it counts the first submenu as 0
		$classes = array( 'sub-menu',
										  ( $display_depth % 2  ? 'menu-odd' : 'menu-even' ),
											( $display_depth >=2 ? 'sub-sub-menu' : '' ),
											'menu-depth-' . $display_depth );
		$class_names = implode( ' ', $classes );
		// build html
		$output .= "\n" . $indent . '<ul class="' . $class_names . '">' . "\n";
	}

	// add main/sub classes to li's and links
	function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ) {
		global $wp_query;

		// Restores the more descriptive, specific name for use within this method.
		$item = $data_object;

		$indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent

		// depth dependent classes
		$depth_classes = array( ( $depth == 0 ? $this->nav_item : 'sub-menu-item' ),
														( $depth >=2 ? 'sub-sub-menu-item' : '' ),
														( $depth % 2 ? 'menu-item-odd' : 'menu-item-even' ),
														'menu-item-depth-' . $depth );

		$depth_class_names = esc_attr( implode( ' ', $depth_classes ) );

		// passed classes
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );

		// build html
		$output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="' . $depth_class_names . ' ' . $class_names . '">';

		// link attributes
		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
		$attributes .= ' class="'. $this->nav_link. ' ' . ( $depth > 0 ? 'sub-menu-link' : 'main-menu-link' ) . '"';

		$item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
			$args->before,
			$attributes,
			$args->link_before,
			apply_filters( 'the_title', $item->title, $item->ID ),
			$args->link_after,
			$args->after
		);

		// build html
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}

function header_menu( $args ) {
	$args = array_merge( [
		'menu_class'		  => 'navbar-nav flex-column text-left',
		'container' 		  => false,
		'menu_id'         => 'header-menu',
		'echo'            => false,
		'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
		'depth'           => 10,
		'walker'          => new Custom_Menu('nav-item', 'nav-link')
	], $args );

	echo wp_nav_menu( $args );
}

function social_menu( $args ) {
	$args = array_merge( [
		'menu_class'		  => 'social-list list-inline py-3 mx-auto',
		'container' 		  => 'false',
		'menu_id'         => 'social-menu',
		'echo'            => false,
		'items_wrap'      => '<ul id="%1$s" class="%2$s>%3$s</ul>', 
		'depth'           => 10,
		'walker'          => new Custom_Menu('list-inline-item', 'list-inline-item')
	], $args );

	echo wp_nav_menu( $args );
}

function words_count_with_read_time(string $content): string {
	$word_count = str_word_count($content);
	return $word_count . ' words ' . ceil( $word_count / 250 ) . ' minutes to read';
}

