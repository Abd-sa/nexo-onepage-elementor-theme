<?php
/**
 * Elementor Testimonials Widget
 *
 * @package NEXO
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class NEXO_Testimonials_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'nexo_testimonials';
	}

	public function get_title() {
		return 'NEXO نظرات مشتریان';
	}

	public function get_icon() {
		return 'eicon-testimonial';
	}

	public function get_categories() {
		return array( 'nexo' );
	}

	public function get_keywords() {
		return array( 'testimonial', 'review', 'nexo', 'نظر' );
	}

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => 'محتوا',
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'count',
			array(
				'label'   => 'تعداد نمایش',
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 3,
				'min'     => 1,
				'max'     => 12,
			)
		);

		$this->add_control(
			'columns',
			array(
				'label'   => 'تعداد ستون',
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => '3',
				'options' => array(
					'1' => '۱',
					'2' => '۲',
					'3' => '۳',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$count    = ! empty( $settings['count'] ) ? absint( $settings['count'] ) : 3;
		$columns  = ! empty( $settings['columns'] ) ? absint( $settings['columns'] ) : 3;

		$query = function_exists( 'nexo_get_testimonials' )
			? nexo_get_testimonials( $count )
			: new WP_Query( array( 'post_type' => 'nexo_testimonial', 'posts_per_page' => $count ) );

		printf( '<div class="nexo-testimonials-grid" style="grid-template-columns:repeat(%d,1fr);">', $columns );

		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				$role   = get_post_meta( get_the_ID(), '_nexo_client_role', true );
				$rating = (int) get_post_meta( get_the_ID(), '_nexo_rating', true );
				if ( $rating < 1 ) {
					$rating = 5;
				}
				?>
				<div class="nexo-testimonial-card">
					<div class="nexo-testimonial-stars" aria-label="امتیاز <?php echo esc_attr( $rating ); ?> از ۵">
						<?php echo esc_html( str_repeat( '★', $rating ) . str_repeat( '☆', max( 0, 5 - $rating ) ) ); ?>
					</div>
					<div class="nexo-testimonial-text"><?php the_content(); ?></div>
					<div class="nexo-testimonial-author">
						<?php
						if ( has_post_thumbnail() ) {
							the_post_thumbnail( 'nexo-avatar' );
						} else {
							echo '<div style="width:48px;height:48px;border-radius:50%;background:#e2e8f0;"></div>';
						}
						?>
						<div>
							<strong><?php the_title(); ?></strong>
							<?php if ( $role ) : ?>
								<span><?php echo esc_html( $role ); ?></span>
							<?php endif; ?>
						</div>
					</div>
				</div>
				<?php
			}
			wp_reset_postdata();
		} else {
			echo '<p style="grid-column:1/-1;text-align:center;color:#64748b;">نظری ثبت نشده. از منوی «نظرات مشتریان» اضافه کنید.</p>';
		}

		echo '</div>';
	}
}
