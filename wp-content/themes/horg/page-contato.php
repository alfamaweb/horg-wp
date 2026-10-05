<?php
/**
 * Template Name: Contato
 *
 * @package AlfamaWeb
 */

defined('ABSPATH') || exit;

get_header();
?>
<main id="conteudo">
	<?php get_template_part('template-parts/breadcrumb', null, array('margem' => 'mb-15')); ?>

	<section class="">
		<div class="container">
			<div class="grid gap-8 grid-cols-12">
				<div class="col-span-12">
					<?php get_template_part('template-parts/form-contato', null, array(
						'titulo' => get_field('formulario_titulo') ?: __('Entre em contato com a Horg', 'alfama-web'),
					)); ?>
				</div>
			</div>
		</div>
	</section>

	<?php
	$localizacao_imagem = get_field('localizacao_imagem');
	$localizacao_maps   = get_field('localizacao_maps');
	$localizacao_waze   = get_field('localizacao_waze');
	$endereco           = aw_field('endereco', 'option', '');
	?>
	<section class="relative isolate" id="localizacao">
		<div class="absolute bg-degrade hidden lg:block right-0 top-0 w-[22%] h-63 rounded-l-[20px] -z-1" aria-hidden="true"></div>
		<div class="container">
			<div class="grid grid-cols-12 gap-8 lg:pt-10">
				<div class="col-span-12 lg:col-span-4 content-center">
					<div class="section-title items-start">
						<div class="eyebrow mb-3"><?php echo esc_html(get_field('localizacao_eyebrow') ?: 'localização'); ?></div>
						<h2><?php echo esc_html(get_field('localizacao_titulo') ?: 'Venha nos fazer uma visita!'); ?></h2>
						<div class="line max-w-[200px]"></div>
					</div>
					<?php if ($endereco): ?>
						<div class="mt-8">
							<div class="rotulo-secao mb-4">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 21s-7-6.2-7-11.5a7 7 0 1 1 14 0C19 14.8 12 21 12 21Z" stroke="#f0607b" stroke-width="2" stroke-linejoin="round"/><circle cx="12" cy="9.5" r="2.5" stroke="#f0607b" stroke-width="2"/></svg>
								<?php esc_html_e('endereço', 'alfama-web'); ?>
							</div>
							<address class="not-italic text-base"><?php echo esc_html(preg_replace('/\s*\n\s*/', ' ', $endereco)); ?></address>
						</div>
					<?php endif; ?>
					<?php if ($localizacao_maps || $localizacao_waze): ?>
						<div class="flex flex-wrap gap-4 mt-10">
							<?php if ($localizacao_maps): ?>
								<a href="<?php echo esc_url($localizacao_maps); ?>" class="btn escuro" target="_blank" rel="noopener">
									<?php esc_html_e('Ver no Google Maps', 'alfama-web'); ?>
								</a>
							<?php endif; ?>
							<?php if ($localizacao_waze): ?>
								<a href="<?php echo esc_url($localizacao_waze); ?>" class="btn escuro" target="_blank" rel="noopener">
									<?php esc_html_e('Ver no Waze', 'alfama-web'); ?>
								</a>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
				<div class="col-span-12 lg:col-span-8">
					<img src="<?php echo esc_url($localizacao_imagem['url'] ?? 'https://placehold.co/1048x415'); ?>"
						alt="<?php echo esc_attr($localizacao_imagem['alt'] ?? __('Fachada da Horg', 'alfama-web')); ?>" class="w-full h-full object-cover rounded-[15px]">
				</div>
			</div>
		</div>
	</section>
</main>
<?php
get_footer();
