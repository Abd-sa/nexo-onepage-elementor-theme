<?php
/**
 * Pricing Section
 *
 * @package NEXO
 */

$plans = array(
	array(
		'name'     => __( 'Basic', 'nexo' ),
		'price'    => '$299',
		'desc'     => __( 'Perfect for small projects', 'nexo' ),
		'features' => array( 'Up to 5 Pages', 'Responsive Design', 'Basic SEO', '1 Month Support' ),
		'popular'  => false,
	),
	array(
		'name'     => __( 'Standard', 'nexo' ),
		'price'    => '$599',
		'desc'     => __( 'Best for growing businesses', 'nexo' ),
		'features' => array( 'Up to 10 Pages', 'Responsive Design', 'SEO Optimization', '3 Months Support' ),
		'popular'  => true,
	),
	array(
		'name'     => __( 'Premium', 'nexo' ),
		'price'    => '$999',
		'desc'     => __( 'For large and complex projects', 'nexo' ),
		'features' => array( 'Unlimited Pages', 'Advanced Features', 'SEO Optimization', '6 Months Support' ),
		'popular'  => false,
	),
);
?>

<section id="pricing" class="nexo-section">
	<div class="nexo-container">
		<div style="text-align:center;margin-bottom:48px;">
			<span style="color:var(--nexo-color-primary);font-weight:600;font-size:14px;"><?php esc_html_e( 'PRICING', 'nexo' ); ?></span>
			<h2 class="nexo-section-title"><?php esc_html_e( 'Simple, Transparent Pricing', 'nexo' ); ?></h2>
		</div>

		<div class="nexo-pricing-grid">
			<?php foreach ( $plans as $plan ) : ?>
				<div class="nexo-price-card <?php echo $plan['popular'] ? 'popular' : ''; ?>">
					<?php if ( $plan['popular'] ) : ?>
						<span class="nexo-price-badge"><?php esc_html_e( 'Popular', 'nexo' ); ?></span>
					<?php endif; ?>
					<h3><?php echo esc_html( $plan['name'] ); ?></h3>
					<div class="nexo-price-amount"><?php echo esc_html( $plan['price'] ); ?></div>
					<p style="color:var(--nexo-color-text-light);font-size:14px;"><?php echo esc_html( $plan['desc'] ); ?></p>
					<ul class="nexo-price-features">
						<?php foreach ( $plan['features'] as $feature ) : ?>
							<li>✓ <?php echo esc_html( $feature ); ?></li>
						<?php endforeach; ?>
					</ul>
					<a href="#contact" class="nexo-btn <?php echo $plan['popular'] ? 'nexo-btn-primary' : 'nexo-btn-outline'; ?>" style="width:100%;justify-content:center;">
						<?php esc_html_e( 'Get Started', 'nexo' ); ?>
					</a>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
