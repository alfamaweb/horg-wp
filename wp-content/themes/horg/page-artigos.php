<?php
/**
 * Molde de página. É este arquivo que o scaffolding copia para page-{slug}.php.
 *
 * @package AlfamaWeb
 */

defined('ABSPATH') || exit;

get_header();

// Página estática: a paginação de uma query secundária usa o query var 'page'
// ('paged' fica zerado fora do loop principal, e este template não usa
// <!--nextpage-->, então não há conflito com a paginação nativa de conteúdo).
$pagina_atual = max(1, (int) get_query_var('page'));

$artigos = new AW_Query_Service('post', array('paged' => $pagina_atual), array(
	'por_pagina' => 9,
	'orderby'    => 'date',
	'order'      => 'DESC',
));

$artigos_query = $artigos->query();
?>
<main id="conteudo">
	<?php get_template_part('template-parts/breadcrumb'); ?>

	<section id="artigos">
		<div class="container">
			<div class="section-title">
				<div class="eyebrow mb-3 lg:mb-4">Nossos Artigos</div>
				<h2>Fique por dentro das dicas e novidades</h2>
				<div class="line max-w-[200px] mb-10"></div>
			</div>

			<?php if ($artigos_query->have_posts()) : ?>
				<div class="grid grid-cols-12 gap-8">
					<?php while ($artigos_query->have_posts()) : $artigos_query->the_post(); ?>
						<div class="col-span-12 md:col-span-6 lg:col-span-4">
							<?php get_template_part('template-parts/card-artigo', null, array('post_id' => get_the_ID())); ?>
						</div>
					<?php endwhile; ?>
				</div>
				<?php wp_reset_postdata(); ?>

				<?php if ($artigos->max_pages() > 1) : ?>
					<nav class="aw-paginacao mt-12" aria-label="<?php esc_attr_e('Paginação', 'alfama-web'); ?>">
						<?php if ($pagina_atual > 1) : ?>
							<a class="aw-pg aw-pg--prev" href="<?php echo esc_url(get_pagenum_link($pagina_atual - 1)); ?>">
								<?php esc_html_e('Anterior', 'alfama-web'); ?>
							</a>
						<?php endif; ?>

						<?php foreach (aw_janela_paginas($pagina_atual, $artigos->max_pages()) as $pagina) : ?>
							<?php if ('…' === $pagina) : ?>
								<span class="aw-pg-elipse" aria-hidden="true">…</span>
							<?php elseif ($pagina === $pagina_atual) : ?>
								<span class="aw-pg is-ativa" aria-current="page"><?php echo esc_html($pagina); ?></span>
							<?php else : ?>
								<a class="aw-pg" href="<?php echo esc_url(get_pagenum_link($pagina)); ?>"><?php echo esc_html($pagina); ?></a>
							<?php endif; ?>
						<?php endforeach; ?>

						<?php if ($pagina_atual < $artigos->max_pages()) : ?>
							<a class="aw-pg aw-pg--next" href="<?php echo esc_url(get_pagenum_link($pagina_atual + 1)); ?>">
								<?php esc_html_e('Próximo', 'alfama-web'); ?>
							</a>
						<?php endif; ?>
					</nav>
				<?php endif; ?>
			<?php else : ?>
				<p class="aw-vazio"><?php esc_html_e('Nenhum artigo publicado ainda.', 'alfama-web'); ?></p>
			<?php endif; ?>
		</div>
	</section>
</main>
<?php
get_footer();
