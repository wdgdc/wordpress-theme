<?php get_header(); ?>

<div id="content">

	<h1 class="archive-title search-title intro-title">
		<span><?php _e('Search Results for:', 'bonestheme'); ?></span>
		&#8220;<?php echo esc_attr(get_search_query()); ?>&#8221;
	</h1>

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
							__( 'Posted <time class="updated" datetime="%1$s" pubdate>%2$s</time> by <span class="author">%3$s</span>' . $categories . '.', 'bonestheme' ),
							get_the_time('Y-m-j'),
							get_the_time(get_option('date_format')),
							bones_get_the_author_posts_link(),
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
	<?php bones_page_navi(); ?>
</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>