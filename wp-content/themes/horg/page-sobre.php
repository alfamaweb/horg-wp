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
	<?php get_template_part('template-parts/breadcrumb'); ?>

	<section id="sobre">
		<div class="container">
			<div class="grid grid-cols-12 gap-8">
				<div class="col-span-12 lg:col-span-6">
					<div class="section-title items-start">
						<div class="eyebrow mb-3 lg:mb-4">agendamento fácil e rápido</div>
						<h2>A Horg está esperando por você!</h2>
						<div class="line max-w-[200px]"></div>
					</div>
				</div>
				<div class="col-span-12 lg:col-span-6">
					<img src="https://placehold.co/775x398" alt="Sobre a Horg" class="w-full h-full object-cover">
				</div>
			</div>
		</div>
	</section>

	<section class="bg-cinza-claro py-16 lg:py-22">
		<div class="container">
			<div class="grid grid-cols-12 gap-8">
				<div class="col-span-12 lg:col-span-4">
					<div class="card !drop-shadow-sombra-1 px-6 py-8">
						<div class="section-title items-center text-center">
							<h3>Missão</h2>
							<div class="line max-w-[200px]"></div>
						</div>
					</div>
				</div>
				<div class="col-span-12 lg:col-span-4">
					<div class="card !drop-shadow-sombra-1 px-6 py-8">
						<div class="section-title items-center text-center">
							<h3>Visão</h2>
							<div class="line max-w-[200px]"></div>
						</div>
					</div>
				</div>
				<div class="col-span-12 lg:col-span-4">
					<div class="card !drop-shadow-sombra-1 px-6 py-8">
						<div class="section-title items-center text-center">
							<h3>Valores</h2>
							<div class="line max-w-[200px]"></div>
						</div>
					</div>
				</div>
			</div>
	</section>

	<section id="equipe">
		<div class="container">
			<div class="flex flex-row justify-between items-end mb-11">
				<div class="section-title items-start text-start mb-0">
					<div class="eyebrow mb-3 lg:mb-4">Nossa equipe</div>
					<h2>Profissionais que cuidam de você</h2>
					<div class="line max-w-[200px]"></div>
				</div>
				<div class="custom-navs flex flex-row items-center gap-6">
					<div class="btn-prev bg-azul rounded-[5px] w-15 h-15"></div>
					<div class="btn-next bg-azul rounded-[5px] w-15 h-15"></div>
				</div>
			</div>
			<div class="swiper equipe"
				data-aw-swiper='{"loop":false,"slidesPerView":4,"spaceBetween":30,"navigation":{"nextEl":".btn-next","prevEl":".btn-prev"}}'>
				<div class="swiper-wrapper">
					<div class="swiper-slide">
						<div class="card p-8 rounded-[10px] bg-azul text-white">
							<div class="flex flex-col items-start gap-6 lg:gap-8">
								<img src="<?= IMG_URI ?>bx_health.svg" alt="Medico" class="w-6 h-6">
								<h3>JOÃO VITOR SANTANA DANTAS</h3>
								<div class="uppercase text-2xl leading-[160%]">MÉDICO ANESTESISTA - CRM 8362</div>
							</div>
						</div>
					</div>
					<div class="swiper-slide">
						<div class="card p-8 rounded-[10px] bg-azul text-white">
							<div class="flex flex-col items-start gap-6 lg:gap-8">
								<img src="<?= IMG_URI ?>bx_health.svg" alt="Medico" class="w-6 h-6">
								<h3>JOÃO VITOR SANTANA DANTAS</h3>
								<div class="uppercase text-2xl leading-[160%]">MÉDICO ANESTESISTA - CRM 8362</div>
							</div>
						</div>
					</div>
					<div class="swiper-slide">
						<div class="card p-8 rounded-[10px] bg-azul text-white">
							<div class="flex flex-col items-start gap-6 lg:gap-8">
								<img src="<?= IMG_URI ?>bx_health.svg" alt="Medico" class="w-6 h-6">
								<h3>JOÃO VITOR SANTANA DANTAS</h3>
								<div class="uppercase text-2xl leading-[160%]">MÉDICO ANESTESISTA - CRM 8362</div>
							</div>
						</div>
					</div>
					<div class="swiper-slide">
						<div class="card p-8 rounded-[10px] bg-azul text-white">
							<div class="flex flex-col items-start gap-6 lg:gap-8">
								<img src="<?= IMG_URI ?>bx_health.svg" alt="Medico" class="w-6 h-6">
								<h3>JOÃO VITOR SANTANA DANTAS</h3>
								<div class="uppercase text-2xl leading-[160%]">MÉDICO ANESTESISTA - CRM 8362</div>
							</div>
						</div>
					</div>
					<div class="swiper-slide">
						<div class="card p-8 rounded-[10px] bg-azul text-white">
							<div class="flex flex-col items-start gap-6 lg:gap-8">
								<img src="<?= IMG_URI ?>bx_health.svg" alt="Medico" class="w-6 h-6">
								<h3>JOÃO VITOR SANTANA DANTAS</h3>
								<div class="uppercase text-2xl leading-[160%]">MÉDICO ANESTESISTA - CRM 8362</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section id="equipamentos">
		<div class="container">
			<div class="grid grid-cols-12 gap-8">
				<div class="col-span-12 lg:col-span-6">
					<img src="https://placehold.co/775x398" alt="Sobre a Horg" class="w-full h-full object-cover">
				</div>
				<div class="col-span-12 lg:col-span-6">
					<div class="section-title items-start">
						<div class="eyebrow mb-3 lg:mb-4">agendamento fácil e rápido</div>
						<h2>A Horg está esperando por você!</h2>
						<div class="line max-w-[200px]"></div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<?php get_template_part('template-parts/cta-agendamento'); ?>
</main>
<?php
get_footer();