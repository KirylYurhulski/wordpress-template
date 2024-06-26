<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Blog
 */

	get_header();
?>

	<main id="primary" class="site-main">
		<section class="blog-list px-3 py-5 p-md-5">
			<div class="container">
				<?php
					while ( have_posts() ) :
						the_post();
					?>

						<article id="post-<?php the_ID(); ?>" class="blog-post px-3 py-5 p-md-5">
							<div class="container">
								<header class="blog-post-header">
									<h2 class="title mb-2"><?= get_the_title()?></h2>
									<div class="meta mb-3">
										<span class="date"><?= get_the_date(); ?></span>
										<span class="time">
											<?php echo words_count_with_read_time(get_the_content());?>
										</span>
										<?php 
											if ( comments_open() || get_comments_number() ) :
												echo '<span class="comment">' . get_comments_number() . ' comments </span>';
											endif;
										?>	
								</header>			    
								<div class="blog-post-body">
									<?= get_the_content()?>
									<hr/>
								</div>	
								<footer class="entry-footer">
									<?php 
										the_post_navigation(
											array(
												'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'blog' ) . '</span> <span class="nav-title">%title</span>',
												'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'blog' ) . '</span> <span class="nav-title">%title</span>',
											)
										);
									?>
								</footer><!-- .entry-footer -->														
						</article>
					<?php
					endwhile; // End of the loop.
				?>
			</div>
		</section>
	</main><!-- #main -->
<?php
//get_sidebar();
get_footer();
