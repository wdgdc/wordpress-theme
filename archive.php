<?php get_header(); ?>

<div id="content">

	<?php if ( is_home() ) : ?>
		<h1 class="archive-title archive-posts-title intro-title">
			<span><?php _e( 'News', THEME_TEXT_DOMAIN ); ?></span>
		</h1>

	<?php elseif ( is_category() ) : ?>
		<h1 class="archive-title archive-category-title intro-title">
			<span><?php _e( 'Posts Categorized:', THEME_TEXT_DOMAIN ); ?></span> <?php single_cat_title(); ?>
		</h1>

	<?php elseif ( is_search() ) : ?>
		<h1 class="archive-title archive-search-title intro-title">
			<span><?php _e( 'Search:', THEME_TEXT_DOMAIN ); ?></span> <?php echo get_search_query(); ?>
		</h1>

	<?php elseif ( is_tag() ) : ?>
		<h1 class="archive-title archive-tag-title intro-title">
			<span><?php _e( 'Posts Tagged:', THEME_TEXT_DOMAIN ); ?></span> <?php single_tag_title(); ?>
		</h1>

	<?php elseif ( is_author() ) : ?>
		<?php $author_id = $post->post_author; ?>
		<h1 class="archive-title archive-author-title intro-title">
			<span><?php _e( 'Posts By:', THEME_TEXT_DOMAIN ); ?></span> <?php the_author_meta( 'display_name', $author_id ); ?>
		</h1>

	<?php elseif ( is_day() ) : ?>
		<h1 class="archive-title archive-day-title intro-title">
			<span><?php _e( 'Daily Archives:', THEME_TEXT_DOMAIN ); ?></span>
			<?php the_time( 'F' ); ?>&nbsp;<?php the_time( 'j' ); ?>,&nbsp;<?php the_time( 'Y' ); ?>
		</h1>

	<?php elseif ( is_month() ) : ?>
		<h1 class="archive-title archive-month-title intro-title">
			<span><?php _e( 'Monthly Archives:', THEME_TEXT_DOMAIN ); ?></span> <?php the_time( 'F Y' ); ?>
		</h1>

	<?php elseif ( is_year() ) : ?>
		<h1 class="archive-title archive-year-title intro-title">
			<span><?php _e( 'Yearly Archives:', THEME_TEXT_DOMAIN ); ?></span> <?php the_time( 'Y' ); ?>
		</h1>

	<?php endif; ?>

	<?php while ( have_posts() ) : the_post(); ?>

		<article id="<?php echo get_post_type(); ?>-<?php the_ID(); ?>" <?php post_class(); ?> role="article">
			<div class="entry-header">
				<?php if ( has_post_thumbnail() ) : ?>
					<div class="featured-image">
						<?php the_post_thumbnail(); ?>
					</div>
				<?php endif; ?>

				<h2 class="entry-title">
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</h2>

				<?php
					// Check if post type returned supports page hierarchy and menu order. If so, don't show post meta
					if ( ! post_type_supports( $post->post_type, 'page-attributes' ) ) :
				?>
					<p class="entry-byline vcard">
						<?php
								$categories = ( is_single() ) ? ' <span class="amp">&</span> filed under %4$s' : '';
								printf(
									__( 'Posted <time class="updated" datetime="%1$s" pubdate>%2$s</time> by <span class="author">%3$s</span>' . $categories . '.', THEME_TEXT_DOMAIN ),
									get_the_time( 'Y-m-j' ),
									get_the_time( get_option( 'date_format' ) ),
									get_the_author_link(),
									get_the_category_list( ', ' )
								);
							?>
					</p>
				<?php endif ?>
			</div>
			<div class="entry-content clearfix" itemprop="articleBody">
				<?php echo Theme::get_excerpt( get_the_ID() ); ?>
			</div>
		</article>

	<?php endwhile; ?>
	<?php posts_nav_link(); ?>
</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
