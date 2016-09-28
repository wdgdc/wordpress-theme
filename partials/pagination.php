<?php
	$total = max( 1, $total );
	$paged = max( 1, $paged );
	$prev = $paged - 1;
	$next = $paged + 1;

	$pagination = paginate_links( array(
		'prev_next' => false,
		'current' => $paged,
		'total' => $total,
	) );

	if ( $total > 1 ) :
?>

	<div class="pagination">
		<?php if ( $paged > 1 ) : ?>
			<a class="pagination__prev" href="<?php previous_posts(); ?>">
				Previous
			</a>
		<?php else : ?>
			<span class="pagination__prev pagination__prev--disabled">
				Previous
			</span>
		<?php endif; ?>

		<?php echo $pagination; ?>

		<?php if ( $paged < $total ) : ?>
			<a class="pagination__next" href="<?php next_posts(); ?>">
				Next
			</a>
		<?php else : ?>
			<span class="pagination__next pagination__next--disabled">
				Next
			</span>
		<?php endif; ?>
	</div>

<?php else : ?>
	<!-- no pagination -->
<?php endif; ?>
