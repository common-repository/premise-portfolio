<?php
/**
 * Premise Portfolio Loop Template
 *
 * This template is loaded by the shortcode
 *
 * @package premise-portfolio\view
 */

?>

<section id="pwpp-portfolio-grid" class="premise-block premise-clear-float">

	<div class="pwpp-container premise-clear-float">

		<?php if ( pwpp_have_posts() ) : ?>

			<div class="pwpp-the-loop">
				<div <?php pwpp_loop_class(); ?>>

					<?php while ( pwpp_have_posts() ) : pwpp_the_post(); ?>

							<div <?php pwpp_loop_item_class( 'pwpp-item' ); ?>>
									<div class="pwpp-item-inner">

										<div class="pwpp-post-title">
											<a href="<?php the_permalink(); ?>">
												<h3><?php the_title(); ?></h3>
											</a>
										</div>

										<div class="pwpp-post-thumbnail">
											<a href="<?php the_permalink(); ?>">
												<?php the_post_thumbnail( 'pwpp-loop-thumbnail', array( 'class' => 'pwp-responsive' ) ); ?>
											</a>
										</div>

										<div class="pwpp-post-excerpt">
											<?php ( apply_filters( 'pwp_portfolio_loop_excerpt' ) )
												? the_excerpt()
												: the_content(); ?>
										</div>

										<div class="pwpp-post-meta">
											<div class="pwpp-author">By: <?php the_author(); ?></div>
											<div class="pwpp-cats">Categories: <?php the_terms( get_the_ID(), 'premise-portfolio-category', '', ', ' ); ?></div>
											<div class="pwpp-tags">Tags: <?php the_terms( get_the_ID(), 'premise-portfolio-tag', '', ', ' ); ?></div>
										</div>

									</div>
							</div>

					<?php endwhile; ?>

				</div>
			</div>

		<?php endif; ?>

	</div>

</section>
