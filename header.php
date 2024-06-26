<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Blog
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<script defer
		src="https://use.fontawesome.com/releases/v5.7.1/js/all.js"
		integrity="sha384-eVEQC9zshBn0rFj4+TU78eNA19HMNigMviK/PU/FFjLXqa/GKPgX58rvt5Z8PLs7" crossorigin="anonymous">
	</script>
 
	<?php wp_head(); ?>
	<script async src="https://cse.google.com/cse.js?cx=2069ff9aaf5234979"></script>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
	<header class="header text-center">	    
		<nav class="navbar navbar-expand-lg navbar-dark" >
			<button
				class="navbar-toggler"
				type="button"
				data-toggle="collapse"
				data-target="#navigation"
				aria-controls="navigation"
				aria-expanded="false"
				aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div id="navigation" class="collapse navbar-collapse flex-column" >
				<div class="profile-section pt-3 pt-lg-0">
						<img
							class="profile-image mb-3 rounded-circle mx-auto"
							src="<?php echo get_template_directory_uri() . '/assets/images/profile.png' ?>" alt="image" >			
					
						<?php
							$blog_description = get_bloginfo( 'description', 'display' );
							if ( $blog_description || is_customize_preview() ) : ?>
							<div class="bio auto">
								<?php echo $blog_description; ?>
							</div>
						<?php endif; ?>
					  
						<?php social_menu( [ 'theme_location'  => 'menu-3' ] ); ?>
					<hr> 
				</div>
				
				<?php
					header_menu( [ 'theme_location'  => 'menu-2' ] );
				?>				
				
				<div class="my-2 my-md-3">
						<a class="btn btn-primary" href="https://themes.3rdwavemedia.com/" target="_blank">Subscribe</a>
				</div>
			</div>
		</nav>
	</header>

	<div class="main-wrapper">
		<section class="cta-section theme-bg-light py-5">
			<div class="container text-center">		
				<h4>
					<a style="color:black" href="<?php echo esc_url( home_url( '/' ) ); ?>">
						<?php bloginfo( 'name' ); ?>
					</a>
				</h4>
				
				<div class="gcse-search"></div>
			</div><!--//container-->
		</section>
