<?php get_header(); ?>

<div id="content">
	<?php while (have_posts()) : the_post(); ?>

		<article id="<?php echo get_post_type(); ?>-<?php the_ID(); ?>" <?php post_class(); ?> role="article">
			<div class="entry-header">
				<h1 class="entry-title">
					<?php the_title(); ?>
				</h1>
				<p class="entry-byline vcard">
					<?php
						$categories = (has_category()) ? ' <span class="amp">&</span> filed under %4$s' : '';
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
				<?php the_content(); ?>
			</div>

			<div class="entry-footer">
				<p class="entry-tags">
					<?php the_tags( '<span class="tags-title">' . __( 'Tags:', 'bonestheme' ) . '</span> ', ', ', '' ); ?>
				</p>
			</div>

			<?php posts_nav_link(); ?>
			<?php comments_template(); ?>
		</article>

	<?php endwhile; ?>
</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>