<?php
/**
 * Single Portfolio template
 *
 * @package NEXO
 */

get_header();
?>

<main id="primary" class="nexo-section">
	<div class="nexo-container" style="max-width:900px;">
		<?php
		while ( have_posts() ) :
			the_post();
			$client = get_post_meta( get_the_ID(), '_nexo_client', true );
			$url    = get_post_meta( get_the_ID(), '_nexo_project_url', true );
			$terms  = get_the_terms( get_the_ID(), 'nexo_portfolio_cat' );
			?>
			<article <?php post_class( 'nexo-single-portfolio' ); ?>>
				<p style="margin-bottom:12px;">
					<a href="<?php echo esc_url( get_post_type_archive_link( 'nexo_portfolio' ) ); ?>">← بازگشت به نمونه کارها</a>
				</p>

				<header style="margin-bottom:28px;">
					<?php if ( $terms && ! is_wp_error( $terms ) ) : ?>
						<span style="color:var(--nexo-color-primary);font-weight:600;font-size:14px;">
							<?php echo esc_html( $terms[0]->name ); ?>
						</span>
					<?php endif; ?>
					<h1 class="nexo-section-title" style="margin-top:8px;"><?php the_title(); ?></h1>
					<?php if ( $client ) : ?>
						<p style="color:var(--nexo-color-text-light);">مشتری: <?php echo esc_html( $client ); ?></p>
					<?php endif; ?>
				</header>

				<?php if ( has_post_thumbnail() ) : ?>
					<div style="margin-bottom:32px;border-radius:16px;overflow:hidden;">
						<?php the_post_thumbnail( 'large' ); ?>
					</div>
				<?php endif; ?>

				<div class="entry-content" style="line-height:1.8;margin-bottom:32px;">
					<?php the_content(); ?>
				</div>

				<?php if ( $url ) : ?>
					<p>
						<a class="nexo-btn nexo-btn-primary" href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer">
							مشاهده پروژه
						</a>
					</p>
				<?php endif; ?>
			</article>
			<?php
		endwhile;
		?>
	</div>
</main>

<?php
get_footer();
