<?php
/**
 * About Section
 *
 * @package NEXO
 */
?>

<section id="about" class="nexo-section" style="background:var(--nexo-color-bg-alt,#f8fafc);">
	<div class="nexo-container">
		<div class="nexo-about-grid">
			<div class="nexo-about-image">
				<div style="background:#e2e8f0;border-radius:16px;aspect-ratio:4/3;display:flex;align-items:center;justify-content:center;color:#64748b;">
					<?php esc_html_e( 'About Image – Replace via Elementor', 'nexo' ); ?>
				</div>
			</div>

			<div class="nexo-about-content">
				<span style="color:var(--nexo-color-primary);font-weight:600;font-size:14px;"><?php esc_html_e( 'ABOUT ME', 'nexo' ); ?></span>
				<h2 class="nexo-section-title"><?php esc_html_e( 'Designing Solutions That Make a Difference', 'nexo' ); ?></h2>
				<p class="nexo-section-subtitle">
					<?php esc_html_e( 'I combine creativity, technology and strategy to build products that are not only beautiful but also functional and impactful.', 'nexo' ); ?>
				</p>

				<div class="nexo-skills">
					<div class="nexo-skill">
						<div class="nexo-skill-header">
							<span>UI/UX Design</span>
							<span>95%</span>
						</div>
						<div class="nexo-skill-bar"><div class="nexo-skill-fill" style="width:95%"></div></div>
					</div>
					<div class="nexo-skill">
						<div class="nexo-skill-header">
							<span>Web Development</span>
							<span>90%</span>
						</div>
						<div class="nexo-skill-bar"><div class="nexo-skill-fill" style="width:90%"></div></div>
					</div>
					<div class="nexo-skill">
						<div class="nexo-skill-header">
							<span>Branding Design</span>
							<span>85%</span>
						</div>
						<div class="nexo-skill-bar"><div class="nexo-skill-fill" style="width:85%"></div></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
