<?php
/**
 * Elementor Portfolio Grid Widget
 *
 * @package NEXO
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class NEXO_Portfolio_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'nexo_portfolio';
	}

	public function get_title() {
		return 'NEXO نمونه کارها';
	}

	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	public function get_categories() {
		return array( 'nexo' );
	}

	public function get_keywords() {
		return array( 'portfolio', 'gallery', 'nexo', 'نمونه کار' );
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
				'default' => 8,
				'min'     => 1,
				'max'     => 24,
			)
		);

		$this->add_control(
			'columns',
			array(
				'label'   => 'تعداد ستون',
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => '4',
				'options' => array(
					'2' => '۲',
					'3' => '۳',
					'4' => '۴',
				),
			)
		);

		$this->add_control(
			'show_filters',
			array(
				'label'        => 'نمایش فیلتر دسته‌ها',
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => 'بله',
				'label_off'    => 'خیر',
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$count    = ! empty( $settings['count'] ) ? absint( $settings['count'] ) : 8;
		$columns  = ! empty( $settings['columns'] ) ? absint( $settings['columns'] ) : 4;
		$filters  = ( 'yes' === ( $settings['show_filters'] ?? '' ) );

		$query = function_exists( 'nexo_get_portfolio_items' )
			? nexo_get_portfolio_items( $count )
			: new WP_Query( array( 'post_type' => 'nexo_portfolio', 'posts_per_page' => $count ) );

		if ( $filters && function_exists( 'nexo_get_portfolio_categories' ) ) {
			$cats = nexo_get_portfolio_categories();
			if ( ! empty( $cats ) && ! is_wp_error( $cats ) ) {
				echo '<div class="nexo-portfolio-filters">';
				echo '<button type="button" class="nexo-filter-btn active" data-filter="*">همه</button>';
				foreach ( $cats as $cat ) {
					printf(
						'<button type="button" class="nexo-filter-btn" data-filter=".cat-%s">%s</button>',
						esc_attr( $cat->slug ),
						esc_html( $cat->name )
					);
				}
				echo '</div>';
			}
		}

		printf( '<div class="nexo-portfolio-grid" style="grid-template-columns:repeat(%d,1fr);">', $columns );

		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				$terms     = get_the_terms( get_the_ID(), 'nexo_portfolio_cat' );
				$classes   = array( 'nexo-portfolio-item' );
				$cat_label = '';
				if ( $terms && ! is_wp_error( $terms ) ) {
					foreach ( $terms as $t ) {
						$classes[] = 'cat-' . $t->slug;
					}
					$cat_label = $terms[0]->name;
				}
				?>
				<article class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
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
			}
			wp_reset_postdata();
		} else {
			echo '<p style="grid-column:1/-1;text-align:center;color:#64748b;">هنوز نمونه‌کاری ثبت نشده. از منوی «نمونه کارها» اضافه کنید یا دمو را نصب کنید.</p>';
		}

		echo '</div>';
	}
}
