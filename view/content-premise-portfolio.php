<?php
/**
 * Premise Portfolio post view
 *
 * @package premise-portfolio\view
 */
global $pwp_portfolio_content;

?><div id="pwpp-portfolio-content"><?
	pwpp_the_custom_fields(); ?>

	<!-- The content -->
	<div class="pwpp-post-content">
		<?php echo $pwp_portfolio_content; ?>
	</div>

	<!-- The category -->
	<div class="pwpp-post-category">
		<?php echo ( $category_list = get_the_term_list( get_the_id(), 'premise-portfolio-category', 'Categories: ', ', ' ) )
			? $category_list
			: ''; ?>
	</div>

	<!-- The tags -->
	<div class="pwpp-post-tags">
		<?php echo ( $tag_list = get_the_term_list( get_the_id(), 'premise-portfolio-tag', 'Tags: ', ', ' ) )
			? $tag_list
			: ''; ?>
	</div>
</div>