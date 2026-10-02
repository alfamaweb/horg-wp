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
	<?php get_template_part('template-parts/breadcrumb'); ?>

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

	<section class="relative isolate" id="sobre">
		<div class="absolute bg-degrade hidden lg:block right-0 top-0 w-[22%] h-63 rounded-l-[20px] -z-1" aria-hidden="true"></div>
		<div class="container">
			<div class="grid grid-cols-12 gap-8 lg:pt-10">
				<div class="col-span-12 lg:col-span-4">
					<div class="section-title items-start">
						<div class="eyebrow mb-3 lg:mb-4"><?php echo esc_html(get_field('destaque_eyebrow') ?: 'Notícia Destaque'); ?></div>
						<h2><?php echo esc_html(get_field('destaque_titulo') ?: 'Daltonismo: Saiba mais sobre o problema'); ?></h2>
						<div class="line max-w-[200px] mb-10"></div>
						<a href="#" class="btn escuro me-auto mt-10">Ler artigo completo</a>
					</div>
				</div>
				<?php $destaque_imagem = get_field('destaque_imagem'); ?>
				<div class="col-span-12 lg:col-span-8">
					<img src="<?php echo esc_url($destaque_imagem['url'] ?? 'https://placehold.co/775x398'); ?>"
						alt="<?php echo esc_attr($destaque_imagem['alt'] ?? 'Sobre a Horg'); ?>" class="w-full h-full object-cover rounded-[15px]">
				</div>
			</div>
		</div>
	</section>
</main>
<?php
get_footer();
