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
						'titulo' => __('Entre em contato com a Horg', 'alfama-web'),
					)); ?>
				</div>
			</div>
		</div>
	</section>

	<section id="sobre">
		<div class="container">
			<div class="grid grid-cols-12 gap-8">
				<div class="col-span-12 lg:col-span-4">
					<div class="section-title items-start">
						<div class="eyebrow mb-3 lg:mb-4">Notícia Destaque</div>
						<h2>Daltonismo: Saiba mais sobre o problema</h2>
						<div class="line max-w-[200px] mb-10"></div>
						<a href="#" class="btn escuro me-auto mt-10">Ler artigo completo</a>
					</div>
				</div>
				<div class="col-span-12 lg:col-span-8">
					<img src="https://placehold.co/775x398" alt="Sobre a Horg" class="w-full h-full object-cover">
				</div>
			</div>
		</div>
	</section>
</main>
<?php
get_footer();
