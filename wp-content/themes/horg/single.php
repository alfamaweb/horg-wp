<?php
/**
 * Post único do blog. Molde copiado pelo scaffolding para single-{cpt}.php.
 *
 * @package AlfamaWeb
 */

defined('ABSPATH') || exit;

get_header();

while (have_posts()) :
	the_post();

	$categorias = get_the_category();

	$relacionados_args = array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => 3,
		'post__not_in'        => array(get_the_ID()),
		'ignore_sticky_posts' => true,
		'orderby'             => 'date',
		'order'               => 'DESC',
	);

	if ($categorias) {
		$relacionados_args['category__in'] = array($categorias[0]->term_id);
	}

	$relacionados = new WP_Query($relacionados_args);

	if (!$relacionados->have_posts() && $categorias) {
		unset($relacionados_args['category__in']);
		$relacionados = new WP_Query($relacionados_args);
	}
	?>
	<main id="conteudo">
		<?php get_template_part('template-parts/breadcrumb', null, array('titulo' => __('Artigos', 'alfama-web'))); ?>

		<?php if (has_post_thumbnail()) : ?>
			<?php the_post_thumbnail('aw-hero', array('class' => 'hero-img max-h-86', 'alt' => get_the_title(), 'loading' => 'eager', 'fetchpriority' => 'high')); ?>
		<?php else : ?>
			<div class="aw-placeholder hero-img max-h-86">[ <?php esc_html_e('imagem destacada do artigo', 'alfama-web'); ?> ]</div>
		<?php endif; ?>

		<article class="single-post py-12 lg:py-20">
			<div class="container">
				<div class="section-title items-start text-start mb-0">
					<h1><?php the_title(); ?></h1>
					<div class="line max-w-[200px]"></div>
				</div>

				<div class="mt-8">
					<?php the_content(); ?>
				</div>

				<?php get_template_part('template-parts/compartilhar'); ?>
			</div>
		</article>

		<?php if ($relacionados->have_posts()) : ?>
			<section id="outros-artigos">
				<div class="container">
					<div class="section-title items-start text-start mb-10">
						<div class="eyebrow mb-3 lg:mb-4"><?php esc_html_e('outros artigos', 'alfama-web'); ?></div>
						<h2><?php esc_html_e('Notícias relacionadas que você pode gostar', 'alfama-web'); ?></h2>
						<div class="line max-w-[200px]"></div>
					</div>

					<div class="grid grid-cols-12 gap-8">
						<?php while ($relacionados->have_posts()) : $relacionados->the_post(); ?>
							<div class="col-span-12 md:col-span-6 lg:col-span-4">
								<?php get_template_part('template-parts/card-artigo', null, array('post_id' => get_the_ID())); ?>
							</div>
						<?php endwhile; ?>
					</div>
				</div>
			</section>
			<?php wp_reset_postdata(); ?>
		<?php endif; ?>
	</main>
	<?php
endwhile;

get_footer();
