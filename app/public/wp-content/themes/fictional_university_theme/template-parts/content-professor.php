<ul class="professor-cards">
	<li class="professor-card__list-item">
		<a class= "professor-card" href="<?php echo get_the_permalink() ?>">
			<img class="professor-card__image" src="<?php the_post_thumbnail_url('landscape') ?>"></img>
			<span class="professor-card__name"><?php the_title(); ?></span>
		</a>
	</li>
</ul>