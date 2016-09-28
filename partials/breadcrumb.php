<?php

$items = Theme_Breadcrumb::get_items();

if ( ! empty( $items ) ) :
	$last_index = count( $items ) - 1;

?>

	<nav class="breadcrumb">
		<ul class="breadcrumb__list">
			<?php foreach ( $items as $item_index => $item ) : ?>
				<?php if ( $item_index === $last_index ) : ?>
					<li class="breadcrumb__list-item">
						<span class="breadcrumb__list-item breadcrumb__list-item--active"><?php echo $item['title']; ?></span>
					</li>
				<?php else : ?>
					<li class="breadcrumb__list-item">
						<a class="breadcrumb__link" href="<?php echo $item['permalink']; ?>"><?php echo $item['title']; ?></a>
					</li>
				<?php endif; ?>
			<?php endforeach; ?>
		</ul>
	</nav>

<?php

endif;
