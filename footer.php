<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Blog
 */

?>

				<footer class="footer text-center py-2 theme-bg-dark">
					<small class="copyright">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
					</small>
				</footer>
			</div><!--//main-wrapper-->
		<?php wp_footer(); ?>
	</body>
</html>
