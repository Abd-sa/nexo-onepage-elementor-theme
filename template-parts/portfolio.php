<?php
/**
 * Portfolio Section - Dynamic from CPT
 *
 * @package NEXO
 */

$count = nexo_get_option( 'portfolio_count', 8 );
$query = nexo_get_portfolio_items( $count );
$cats  = nexo_get_portfolio_categories();
?>

<section id="portfolio" class="nexo-section">
	<div class="nexo-container">
		<div style="display:flex;justify-content:space-between;align-items:flex-end;flex-wrap:wrap;gap:20px;margin-bottom:32px;">
			<div>
				<span style="color:var(--nexo-color-primary);font-weight:600;font-size:14px;"><?php esc_html_e( 'PORTFOLIO', 'nexo' ); ?></span>
				<h2 class="nexo-section-title" style="margin-bottom:0;"><?php esc_html_e( 'Selected Works', 'nexo' ); ?></h2>
			</div>

			<?php if ( ! empty( $cats ) && ! is_wp_error( $cats ) ) : ?>
				<div class="nexo-portfolio-filters">
					<button class="nexo-filter-btn active" data-filter="*">All</button>
					<?php foreach ( $cats as $cat ) : ?>
						<button class="nexo-filter-btn" data-filter=".cat-<?php echo esc_attr( $cat->slug ); ?>">
							<?php echo esc_html( $cat->name ); ?>
						</button>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>

		<div class="nexo-portfolio-grid">
			<?php if ( $query->have_posts() ) : ?>
				<?php
				while ( $query->have_posts() ) :
					$query->the_post();
					$terms     = get_the_terms( get_the_ID(), 'nexo_portfolio_cat' );
					$term_slugs = array();
					$term_names = array();
					if ( $terms && ! is_wp_error( $terms ) ) {
						foreach ( $terms as $t ) {
							$term_slugs[] = 'cat-' . $t->slug;
							$term_names[] = $t->name;
						}
					}
					$class = implode( ' ', $term_slugs );
					?>
					<article class="nexo-portfolio-item <?php echo esc_attr( $class ); ?>">
						<a href="<?php the_permalink(); ?>">
							<?php if ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail( 'nexo-portfolio' ); ?>
							<?php else : ?>
								<div style="height:200px;background:#e2e8f0;display:flex;align-items:center;justify-content:center;color:#94a3b8;">
									<?php esc_html_e( 'No Image', 'nexo' ); ?>
								</div>
							<?php endif; ?>
							<div class="nexo-portfolio-info">
								<h4><?php the_title(); ?></h4>
								<span class="nexo-portfolio-cat"><?php echo esc_html( implode( ', ', $term_names ) ); ?></span>
							</div>
						</a>
					</article>
				<?php endwhile; ?>
				<?php wp_reset_postdata(); ?>
			<?php else : ?>
				<p style="grid-column:1/-1;text-align:center;color:var(--nexo-color-text-light);">
					<?php esc_html_e( 'No portfolio items yet. Add projects from Portfolio menu in admin.', 'nexo' ); ?>
				</p>
			<?php endif; ?>
		</div>

		<div style="text-align:center;margin-top:40px;">
			<a href="<?php echo esc_url( get_post_type_archive_link( 'nexo_portfolio' ) ); ?>" class="nexo-btn nexo-btn-outline">
				<?php esc_html_e( 'View All Projects', 'nexo' ); ?> →
			</a>
		</div>
	</div>
</section>
