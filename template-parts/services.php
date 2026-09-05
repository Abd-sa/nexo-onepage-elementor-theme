<?php
/**
 * Services Section
 *
 * @package NEXO
 */

$services = array(
	array(
		'icon'  => '✏️',
		'title' => __( 'UI/UX Design', 'nexo' ),
		'desc'  => __( 'I design intuitive and beautiful interfaces that users love.', 'nexo' ),
	),
	array(
		'icon'  => '</>',
		'title' => __( 'Web Development', 'nexo' ),
		'desc'  => __( 'I build fast, responsive and modern websites.', 'nexo' ),
	),
	array(
		'icon'  => '🎨',
		'title' => __( 'Branding Design', 'nexo' ),
		'desc'  => __( 'I create unique brand identities that stand out.', 'nexo' ),
	),
	array(
		'icon'  => '📈',
		'title' => __( 'SEO Optimization', 'nexo' ),
		'desc'  => __( 'I optimize websites to rank higher and get more traffic.', 'nexo' ),
	),
);
?>

<section id="services" class="nexo-section" style="background:var(--nexo-color-dark);color:#fff;">
	<div class="nexo-container">
		<div style="text-align:center;margin-bottom:48px;">
			<span style="color:var(--nexo-color-primary);font-weight:600;font-size:14px;"><?php esc_html_e( 'SERVICES', 'nexo' ); ?></span>
			<h2 class="nexo-section-title" style="color:#fff;"><?php esc_html_e( 'What I Can Do For You', 'nexo' ); ?></h2>
		</div>

		<div class="nexo-services-grid">
			<?php foreach ( $services as $service ) : ?>
				<div class="nexo-service-card">
					<div class="nexo-service-icon"><?php echo esc_html( $service['icon'] ); ?></div>
					<h3><?php echo esc_html( $service['title'] ); ?></h3>
					<p><?php echo esc_html( $service['desc'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
