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
						<div class="eyebrow mb-3 lg:mb-4"><?php echo esc_html(get_field('sobre_eyebrow') ?: 'agendamento fácil e rápido'); ?></div>
						<h2><?php echo esc_html(get_field('sobre_titulo') ?: 'A Horg está esperando por você!'); ?></h2>
						<div class="line max-w-[200px]"></div>
					</div>
				</div>
				<?php $sobre_imagem = get_field('sobre_imagem'); ?>
				<div class="col-span-12 lg:col-span-6">
					<div class="relative isolate h-full pt-6 pr-6 lg:pt-11 lg:pr-10">
						<div class="absolute bg-degrade right-0 top-0 w-1/2 h-2/3 rounded-[15px] -z-1" aria-hidden="true"></div>
						<img src="<?php echo esc_url($sobre_imagem['url'] ?? 'https://placehold.co/775x398'); ?>"
							alt="<?php echo esc_attr($sobre_imagem['alt'] ?? 'Sobre a Horg'); ?>" class="w-full h-full object-cover rounded-[15px]">
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="bg-cinza-claro py-16 lg:py-22">
		<div class="container">
			<div class="grid grid-cols-12 gap-8">
				<?php if (have_rows('equipe')): ?>
					<?php while (have_rows('equipe')): the_row();
						$equipe_membro_titulo = get_sub_field('titulo');
						$equipe_membro_texto  = get_sub_field('texto');
						?>
						<div class="col-span-12 lg:col-span-6 2xl:col-span-3">
							<div class="card !drop-shadow-sombra-1 px-6 py-8">
								<div class="flex flex-col items-start gap-6 lg:gap-8">
									<img src="<?= IMG_URI ?>bx_health.svg" alt="Medico" class="w-6 h-6">
									<h3><?php echo esc_html($equipe_membro_titulo); ?></h3>
									<div class="uppercase text-2xl leading-[160%]"><?php echo esc_html($equipe_membro_texto); ?></div>
								</div>
							</div>
						</div>
					<?php endwhile; ?>
				<?php else: ?>
					<div class="col-span-12 lg:col-span-6 2xl:col-span-3">
						<div class="card !drop-shadow-sombra-1 px-6 py-8">
							<div class="flex flex-col items-start gap-6 lg:gap-8">
								<img src="<?= IMG_URI ?>bx_health.svg" alt="Medico" class="w-6 h-6">
								<h3>JOÃO VITOR SANTANA DANTAS</h3>
								<div class="uppercase text-2xl leading-[160%]">MÉDICO ANESTESISTA - CRM 8362</div>
							</div>
						</div>
					</div>
				<?php endif; ?>
			</div>
	</section>

	<section id="sobre">
		<div class="container">
			<div class="grid grid-cols-12 gap-8">
				<?php $agendamento_imagem = get_field('agendamento_imagem'); ?>
				<div class="col-span-12 lg:col-span-6">
					<div class="relative isolate h-full pt-6 pl-6 lg:pt-11 lg:pl-10">
						<div class="absolute bg-degrade left-0 top-0 w-1/2 h-2/3 rounded-[15px] -z-1" aria-hidden="true"></div>
						<img src="<?php echo esc_url($agendamento_imagem['url'] ?? 'https://placehold.co/775x398'); ?>"
							alt="<?php echo esc_attr($agendamento_imagem['alt'] ?? 'Sobre a Horg'); ?>" class="w-full h-full object-cover rounded-[15px]">
					</div>
				</div>
				<div class="col-span-12 lg:col-span-6">
					<div class="section-title items-start">
						<div class="eyebrow mb-3 lg:mb-4"><?php echo esc_html(get_field('agendamento_eyebrow') ?: 'agendamento fácil e rápido'); ?></div>
						<h2><?php echo esc_html(get_field('agendamento_titulo') ?: 'A Horg está esperando por você!'); ?></h2>
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
					<div class="eyebrow mb-3 lg:mb-4"><?php echo esc_html(get_field('convenios_eyebrow') ?: 'Convênios Médicos'); ?></div>
					<h2><?php echo esc_html(get_field('convenios_titulo') ?: 'Convênios médicos e planos de saúde aceitos na HORG'); ?></h2>
					<div class="line max-w-[200px]"></div>
				</div>
				<div class="custom-navs flex flex-row items-center gap-6">
					<div class="btn-prev bg-azul rounded-[5px] w-15 h-15"></div>
					<div class="btn-next bg-azul rounded-[5px] w-15 h-15"></div>
				</div>
			</div>
			<div class="swiper convenios">
				<div class="swiper-wrapper pb-6">
					<?php $convenios_galeria = get_field('convenios_galeria'); ?>
					<?php if ($convenios_galeria): ?>
						<?php foreach ($convenios_galeria as $convenio_logo): ?>
							<div class="swiper-slide">
								<div class="card p-8 rounded-[10px] text-white drop-shadow-sombra-1">
									<img src="<?php echo esc_url($convenio_logo['url']); ?>"
										alt="<?php echo esc_attr($convenio_logo['alt'] ?? ''); ?>" class="w-full h-auto max-h-25'">
								</div>
							</div>
						<?php endforeach; ?>
					<?php else: ?>
						<div class="swiper-slide">
							<div class="card p-8 rounded-[10px] text-white drop-shadow-sombra-1">
								<img src="<?= IMG_URI ?>bradesco.png" alt="Medico" class="w-full h-auto max-h-25'">
							</div>
						</div>
					<?php endif; ?>
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