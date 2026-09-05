<?php
/**
 * Testimonials Section - Dynamic from CPT
 *
 * @package NEXO
 */

$count = nexo_get_option( 'testimonials_count', 3 );
$query = nexo_get_testimonials( $count );
?>

<section id="testimonials" class="nexo-section" style="background:var(--nexo-color-bg-alt,#f8fafc);">
	<div class="nexo-container">
		<div style="text-align:center;margin-bottom:48px;">
			<span style="color:var(--nexo-color-primary);font-weight:600;font-size:14px;"><?php esc_html_e( 'TESTIMONIALS', 'nexo' ); ?></span>
			<h2 class="nexo-section-title"><?php esc_html_e( 'What Clients Say', 'nexo' ); ?></h2>
		</div>

		<div class="nexo-testimonials-grid">
			<?php if ( $query->have_posts() ) : ?>
				<?php
				while ( $query->have_posts() ) :
					$query->the_post();
					$role = get_post_meta( get_the_ID(), '_nexo_client_role', true );
					?>
					<div class="nexo-testimonial-card">
						<div class="nexo-testimonial-text">
							“<?php echo esc_html( get_the_content() ); ?>”
						</div>
						<div class="nexo-testimonial-author">
							<?php if ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail( 'nexo-avatar' ); ?>
							<?php else : ?>
								<div style="width:48px;height:48px;border-radius:50%;background:#e2e8f0;"></div>
							<?php endif; ?>
							<div>
								<strong><?php the_title(); ?></strong>
								<?php if ( $role ) : ?>
									<span><?php echo esc_html( $role ); ?></span>
								<?php endif; ?>
							</div>
						</div>
					</div>
				<?php endwhile; ?>
				<?php wp_reset_postdata(); ?>
			<?php else : ?>
				<p style="grid-column:1/-1;text-align:center;color:var(--nexo-color-text-light);">
					<?php esc_html_e( 'No testimonials yet. Add them from Testimonials menu in admin.', 'nexo' ); ?>
				</p>
			<?php endif; ?>
		</div>
	</div>
</section>
