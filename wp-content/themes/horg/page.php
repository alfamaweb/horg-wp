<?php
/**
 * Molde de página. É este arquivo que o scaffolding copia para page-{slug}.php.
 *
 * @package AlfamaWeb
 */

defined('ABSPATH') || exit;

get_header();
?>
<main id="conteudo">
	<section>
		<div class="bg-cinza-claro py-4 mb-23">
			<div class="container">
				<nav class="aw-breadcrumb" aria-label="<?php esc_attr_e('Você está aqui', 'alfama-web'); ?>">
					<a class="font-semibold"
						href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('HOME', 'alfama-web'); ?></a>
					<span class="font-semibold" aria-hidden="true">></span>
					<span class="uppercase text-azul font-bold"><?php echo esc_html(get_the_title()); ?></span>
				</nav>
			</div>
		</div>
	</section>

	<section class="py-12 lg:py-20">
		<div class="container">
			<div class="grid grid-cols-12">
				<div class="col-span-12 lg:col-span-8">
					<div class="aw-prose">
						<?php
						while (have_posts()) {
							the_post();
							the_content();
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="mt-40 mb-0" id="cta">
		<div class="container">
			<div class="holder rounded-t-[25px] bg-[#EDF5FF] max-h-86 flex items-end">
				<div class="grid grid-cols-12 gap-8">
					<div class="col-span-10 col-start-2 flex justify-between items-center">
						<img class="bottom-0" src="<?= IMG_URI ?>Medic.png" alt="">
						<div class="section-title items-center text-center mt-auto">
							<div class="eyebrow mb-3 lg:mb-4">agendamento fácil e rápido</div>
							<h2>A Horg está esperando por você!</h2>
							<div class="line max-w-[300px]"></div>
							<a href="#" class="btn escuro mt-10">Agende sua consulta</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</main>
<?php
get_footer();
