<?php
/**
 * Portfolio archive template
 *
 * @package NEXO
 */

get_header();
?>

<main id="primary" class="nexo-section">
	<div class="nexo-container">
		<header style="margin-bottom:40px;text-align:center;">
			<span style="color:var(--nexo-color-primary);font-weight:600;font-size:14px;">نمونه کارها</span>
			<h1 class="nexo-section-title">پروژه‌های منتخب</h1>
		</header>

		<?php if ( have_posts() ) : ?>
			<div class="nexo-portfolio-grid">
				<?php
				while ( have_posts() ) :
					the_post();
					$terms     = get_the_terms( get_the_ID(), 'nexo_portfolio_cat' );
					$cat_label = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0]->name : '';
					?>
					<article <?php post_class( 'nexo-portfolio-item' ); ?>>
						<a href="<?php the_permalink(); ?>">
							<?php
							if ( has_post_thumbnail() ) {
								the_post_thumbnail( 'nexo-portfolio' );
							} else {
								echo '<div style="height:200px;background:#e2e8f0;display:flex;align-items:center;justify-content:center;color:#94a3b8;">بدون تصویر</div>';
							}
							?>
						</a>
						<div class="nexo-portfolio-info">
							<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
							<?php if ( $cat_label ) : ?>
								<span class="nexo-portfolio-cat"><?php echo esc_html( $cat_label ); ?></span>
							<?php endif; ?>
						</div>
					</article>
					<?php
				endwhile;
				?>
			</div>

			<div style="margin-top:40px;text-align:center;">
				<?php the_posts_pagination(); ?>
			</div>
		<?php else : ?>
			<p style="text-align:center;color:#64748b;">هنوز پروژه‌ای منتشر نشده است.</p>
		<?php endif; ?>
	</div>
</main>

<?php
get_footer();
