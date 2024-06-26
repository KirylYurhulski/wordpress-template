<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Blog
 */

	get_header();
?>
	<main id="primary" class="site-main">
		<section class="blog-list px-3 py-5 p-md-5">
			<div class="container">

				<?php
					if ( have_posts() ) : 
						/* Start the Loop */
						while ( have_posts() ) :
							the_post();

							/*
							* Include the Post-Type-specific template for the content.
							* If you want to override this in a child theme, then include a file
							* called content-___.php (where ___ is the Post Type name) and that will be used instead.
							*/
							//get_template_part( 'template-parts/content', get_post_type() );
						?>
							<article id="post-<?php the_ID(); ?>" class="item mb-5">
								<div class="media">
									<header class="media-body">
										<h3 class="title mb-1">
											<a href="<?= esc_url( get_permalink())?>"><?= get_the_title()?></a>
										</h3>
										<div class="meta mb-1">
											<span class="date"><?= get_the_date()?></span>
											<span class="time">
												<?php echo words_count_with_read_time(get_the_content());?>
											</span>
											<?php 
												if ( comments_open() || get_comments_number() ) :
													echo '<span class="comment">' . get_comments_number() . ' comments </span>';
												endif;
											?>	
										</div>
										<div class="intro">
											<?= the_excerpt()?>
										</div>
										<a class="more-link" href="<?= esc_url( get_permalink())?>">Continue &rarr;</a>
									</header>
								</div>
							</article>						
						<?php	
						endwhile;

						the_posts_navigation(array(
							'prev_text'          => 'Previous',
							'next_text'          => 'Next',
						));
					else :
						get_template_part( 'template-parts/content', 'none' );
					endif;
				?>
			</div>
		</section>
	</main><!-- #main -->
<?php
//get_sidebar();
get_footer();
