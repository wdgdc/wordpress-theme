<?php get_header(); ?>

<div class="MainContainer-content">
	<?php while (have_posts()) : the_post(); ?>

		<article id="<?php echo get_post_type(); ?>-<?php the_ID(); ?>" <?php post_class(); ?> role="article">
			<div class="Entry-header">
				<h1 class="Entry-title">
					<?php the_title(); ?>
				</h1>
				<p class="Entry-byline">
					<?php
						$categories = (has_category()) ? ' <span class="Entry-bylineAmp">&</span> filed under %4$s' : '';
						printf(
							__('Posted <time class="Entry-updated" datetime="%1$s" pubdate>%2$s</time> by <span class="Entry-author">%3$s</span>' . $categories . '.'),
							get_the_time('Y-m-j'),
							get_the_time(get_option('date_format')),
							// Theme::get('author_posts_link'),
							get_the_category_list(', ')
						);
					?>
				</p>
			</div>

			<div class="Entry-content u-cf u-textFormat" itemprop="articleBody">
				<?php the_content(); ?>
			</div>

			<div class="Entry-footer">
				<p class="Entry-tags">
					<?php the_tags( '<span class="Entry-tagsLabel">' . __('Tags:') . '</span> ', ', ', '' ); ?>
				</p>
			</div>

			<?php posts_nav_link(); ?>
			<?php comments_template(); ?>
		</article>

	<?php endwhile; ?>
</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>