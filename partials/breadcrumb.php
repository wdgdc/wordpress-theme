<?php

$items = Theme_Breadcrumb::get_items();

if ( ! empty( $items ) ) :
	$last_index = count( $items ) - 1;

?>

	<nav class="breadcrumb">
		<ul class="breadcrumb-list">
			<?php foreach ( $items as $item_index => $item ) : ?>
				<?php if ( $item_index === $last_index ) : ?>
					<li class="breadcrumb-list-item">
						<span class="breadcrumb-active-item"><?php echo $item['title']; ?></span>
					</li>
				<?php else : ?>
					<li class="breadcrumb-list-item">
						<a class="breadcrumb-link" href="<?php echo $item['permalink']; ?>"><?php echo $item['title']; ?></a>
					</li>
				<?php endif; ?>
			<?php endforeach; ?>
		</ul>
	</nav>

<?php

endif;
