<?php

/*
	
@package rpgmobilefriendlyportfolio
-- Image Post Format
*/
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('rpgportfolio-format-image'); ?>>

		<div class="inner-rpgportfolio-format-image">

			<?php 
				$current_post_id = get_post_thumbnail_id();
				$image_attributes = wp_get_attachment_metadata($current_post_id); 
			?>

			<header class="entry-header background-image-large" style="background-image: url(<?php echo rpg_portfolio_get_attachment(); ?>); background-size: cover; background-repeat: no-repeat; background-position: left top; height: <?php echo $image_attributes["height"]; ?>px; width: <?php echo $image_attributes["width"]; ?>px; margin: 0 auto;">

				<?php the_title( '<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>' ); ?>

				<div class="entry-meta">
					<?php echo rpg_portfolio_posted_meta(); ?>
				</div>

				<div class="entry-excerpt image-caption">
					<?php the_excerpt(); ?>
				</div>

				<div class="button-container">
					<a href="<?php the_permalink(); ?>" class="btn-rpgportfolio"><?php _e( 'Read More' ); ?></a>
				</div>
				
			</header>

			<header class="entry-header background-image-tablet" style="background-image: url(<?php echo rpg_portfolio_get_attachment(); ?>); background-size: cover; background-repeat: no-repeat; background-position: left top; height: <?php echo ($image_attributes["height"] * .7); ?>px; width: <?php echo ($image_attributes["width"] * .7); ?>px; margin: 0 auto;">

				<?php the_title( '<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>' ); ?>

				<div class="entry-meta">
					<?php echo rpg_portfolio_posted_meta(); ?>
				</div>

					<div class="entry-excerpt image-caption">
						<?php the_excerpt(); ?>
					</div>

					<div class="button-container">
						<a href="<?php the_permalink(); ?>" class="btn-rpgportfolio"><?php _e( 'Read More' ); ?></a>
					</div>
				
			</header>

			<div class="background-image-smartphone">
				<?php the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' ); ?>

				<div class="entry-meta">
					<?php echo rpg_portfolio_posted_meta(); ?>
				</div>

				<header class="entry-header" style="background-image: url(<?php echo rpg_portfolio_get_attachment(); ?>); background-size: cover; background-repeat: no-repeat; background-position: left top; height: <?php echo ($image_attributes["height"]  * .3); ?>px; width: <?php echo ($image_attributes["width"]  * .3); ?>px; margin: 0 auto;">
					
				</header>

				<div class="entry-excerpt image-caption-mobile">
						<?php the_excerpt(); ?>
				</div>

				<div class="button-container">
					<a href="<?php the_permalink(); ?>" class="btn-rpgportfolio"><?php _e( 'Read More' ); ?></a>
				</div>

			</div>

		</div>	

	<footer class="entry-footer">
		<?php echo rpg_portfolio_tags(); ?>	
	</footer>

</article>
