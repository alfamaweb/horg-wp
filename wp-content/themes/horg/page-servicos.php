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
				<div class="col-span-12 lg:col-span-6 2xl:col-span-3">
					<div class="card !drop-shadow-sombra-1 px-6 py-8">
						<div class="flex flex-col items-start gap-6 lg:gap-8">
							<img src="<?= IMG_URI ?>bx_health.svg" alt="Medico" class="w-6 h-6">
							<h3>JOÃO VITOR SANTANA DANTAS</h3>
							<div class="uppercase text-2xl leading-[160%]">MÉDICO ANESTESISTA - CRM 8362</div>
						</div>
					</div>
				</div>
				<div class="col-span-12 lg:col-span-6 2xl:col-span-3">
					<div class="card !drop-shadow-sombra-1 px-6 py-8">
						<div class="flex flex-col items-start gap-6 lg:gap-8">
							<img src="<?= IMG_URI ?>bx_health.svg" alt="Medico" class="w-6 h-6">
							<h3>JOÃO VITOR SANTANA DANTAS</h3>
							<div class="uppercase text-2xl leading-[160%]">MÉDICO ANESTESISTA - CRM 8362</div>
						</div>
					</div>
				</div>
				<div class="col-span-12 lg:col-span-6 2xl:col-span-3">
					<div class="card !drop-shadow-sombra-1 px-6 py-8">
						<div class="flex flex-col items-start gap-6 lg:gap-8">
							<img src="<?= IMG_URI ?>bx_health.svg" alt="Medico" class="w-6 h-6">
							<h3>JOÃO VITOR SANTANA DANTAS</h3>
							<div class="uppercase text-2xl leading-[160%]">MÉDICO ANESTESISTA - CRM 8362</div>
						</div>
					</div>
				</div>
				<div class="col-span-12 lg:col-span-6 2xl:col-span-3">
					<div class="card !drop-shadow-sombra-1 px-6 py-8">
						<div class="flex flex-col items-start gap-6 lg:gap-8">
							<img src="<?= IMG_URI ?>bx_health.svg" alt="Medico" class="w-6 h-6">
							<h3>JOÃO VITOR SANTANA DANTAS</h3>
							<div class="uppercase text-2xl leading-[160%]">MÉDICO ANESTESISTA - CRM 8362</div>
						</div>
					</div>
				</div>
				<div class="col-span-12">

				</div>
			</div>
	</section>

	<section id="sobre">
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

	<section id="convenios">
		<div class="container">
			<div class="flex flex-row justify-between items-end mb-11">
				<div class="section-title items-start text-start mb-0">
					<div class="eyebrow mb-3 lg:mb-4">Convênios Médicos</div>
					<h2>Convênios médicos e planos de saúde aceitos na HORG</h2>
					<div class="line max-w-[200px]"></div>
				</div>
				<div class="custom-navs flex flex-row items-center gap-6">
					<div class="btn-prev bg-azul rounded-[5px] w-15 h-15"></div>
					<div class="btn-next bg-azul rounded-[5px] w-15 h-15"></div>
				</div>
			</div>
			<div class="swiper convenios">
				<div class="swiper-wrapper pb-6">
					<div class="swiper-slide">
						<div class="card p-8 rounded-[10px] text-white drop-shadow-sombra-1">
							<img src="<?= IMG_URI ?>bradesco.png" alt="Medico" class="w-full h-auto max-h-25'">
						</div>
					</div>
					<div class="swiper-slide">
						<div class="card p-8 rounded-[10px] text-white drop-shadow-sombra-1">
							<img src="<?= IMG_URI ?>bradesco.png" alt="Medico" class="w-full h-auto max-h-25'">
						</div>
					</div>
					<div class="swiper-slide">
						<div class="card p-8 rounded-[10px] text-white drop-shadow-sombra-1">
							<img src="<?= IMG_URI ?>bradesco.png" alt="Medico" class="w-full h-auto max-h-25'">
						</div>
					</div>
					<div class="swiper-slide">
						<div class="card p-8 rounded-[10px] text-white drop-shadow-sombra-1">
							<img src="<?= IMG_URI ?>bradesco.png" alt="Medico" class="w-full h-auto max-h-25'">
						</div>
					</div>
					<div class="swiper-slide">
						<div class="card p-8 rounded-[10px] text-white drop-shadow-sombra-1">
							<img src="<?= IMG_URI ?>bradesco.png" alt="Medico" class="w-full h-auto max-h-25'">
						</div>
					</div>
					<div class="swiper-slide">
						<div class="card p-8 rounded-[10px] text-white drop-shadow-sombra-1">
							<img src="<?= IMG_URI ?>bradesco.png" alt="Medico" class="w-full h-auto max-h-25'">
						</div>
					</div>
					<div class="swiper-slide">
						<div class="card p-8 rounded-[10px] text-white drop-shadow-sombra-1">
							<img src="<?= IMG_URI ?>bradesco.png" alt="Medico" class="w-full h-auto max-h-25'">
						</div>
					</div>
					<div class="swiper-slide">
						<div class="card p-8 rounded-[10px] text-white drop-shadow-sombra-1">
							<img src="<?= IMG_URI ?>bradesco.png" alt="Medico" class="w-full h-auto max-h-25'">
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<?php get_template_part('template-parts/cta-agendamento'); ?>

</main>
<?php
get_footer();
?>

<script>
	document.addEventListener('DOMContentLoaded', function () {
		const swiperConvenios = new Swiper('.swiper.convenios', {
			loop: false,
			slidesPerView: 6,
			spaceBetween: 30,
			navigation: {
				nextEl: '.btn-next',
				prevEl: '.btn-prev',
			},
		});
	})
</script>