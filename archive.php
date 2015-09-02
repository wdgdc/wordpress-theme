<?php get_header(); ?>

<div id="content">

	<?php if (is_category()) : ?>
		<h1 class="archive-title archive-category-title intro-title">
			<span><?php _e('Posts Categorized:', 'wdg-theme'); ?></span> <?php single_cat_title(); ?>
		</h1>

	<?php elseif (is_tag()) : ?>
		<h1 class="archive-title archive-tag-title intro-title">
			<span><?php _e('Posts Tagged:', 'wdg-theme'); ?></span> <?php single_tag_title(); ?>
		</h1>

	<?php elseif (is_author()) : ?>
		<?php $author_id = $post->post_author; ?>
		<h1 class="archive-title archive-author-title intro-title">
			<span><?php _e('Posts By:', 'wdg-theme'); ?></span> <?php the_author_meta('display_name', $author_id); ?>
		</h1>

	<?php elseif (is_day()) : ?>
		<h1 class="archive-title archive-day-title intro-title">
			<span><?php _e('Daily Archives:', 'wdg-theme'); ?></span>
			<?php the_time('F'); ?>&nbsp;<?php the_time('j'); ?>,&nbsp;<?php the_time('Y'); ?>
		</h1>

	<?php elseif (is_month()) : ?>
		<h1 class="archive-title archive-month-title intro-title">
			<span><?php _e('Monthly Archives:', 'wdg-theme'); ?></span> <?php the_time('F Y'); ?>
		</h1>

	<?php elseif (is_year()) : ?>
		<h1 class="archive-title archive-year-title intro-title">
			<span><?php _e('Yearly Archives:', 'wdg-theme'); ?></span> <?php the_time('Y'); ?>
		</h1>
	
	<?php endif; ?>

	<?php while (have_posts()) : the_post(); ?>

		<article id="<?php echo get_post_type(); ?>-<?php the_ID(); ?>" <?php post_class(); ?> role="article">
			<div class="entry-header">
				<h2 class="entry-title">
					<?php the_title(); ?>
				</h2>
				<p class="entry-byline vcard">
					<?php
						$categories = (is_single()) ? ' <span class="amp">&</span> filed under %4$s' : '';
						printf(
							__( 'Posted <time class="updated" datetime="%1$s" pubdate>%2$s</time> by <span class="author">%3$s</span>' . $categories . '.', 'wdg-theme' ),
							get_the_time('Y-m-j'),
							get_the_time(get_option('date_format')),
							get_the_author_link(),
							get_the_category_list(', ')
						);
					?>
				</p>
			</div>
			<div class="entry-content clearfix" itemprop="articleBody">
				<?php the_excerpt(); ?>
			</div>
		</article>

	<?php endwhile; ?>
	<?php posts_nav_link(); ?>
</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
