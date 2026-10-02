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

	<section id="equipamentos">
		<div class="container">
			<div class="grid grid-cols-12 gap-8">
				<?php $equipamentos_imagem = get_field('equipamentos_imagem'); ?>
				<div class="col-span-12 lg:col-span-6">
					<div class="relative isolate h-full pt-6 pl-6 lg:pt-11 lg:pl-10">
						<div class="absolute bg-degrade left-0 top-0 w-1/2 h-2/3 rounded-[15px] -z-1" aria-hidden="true"></div>
						<img src="<?php echo esc_url($equipamentos_imagem['url'] ?? 'https://placehold.co/775x398'); ?>"
							alt="<?php echo esc_attr($equipamentos_imagem['alt'] ?? 'Sobre a Horg'); ?>" class="w-full h-full object-cover rounded-[15px]">
					</div>
				</div>
				<div class="col-span-12 lg:col-span-6">
					<div class="section-title items-start">
						<div class="eyebrow mb-3 lg:mb-4"><?php echo esc_html(get_field('equipamentos_eyebrow') ?: 'agendamento fácil e rápido'); ?></div>
						<h2><?php echo esc_html(get_field('equipamentos_titulo') ?: 'A Horg está esperando por você!'); ?></h2>
						<div class="line max-w-[200px]"></div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="bg-azul py-12 lg:py-18" id="diferenciais">
		<div class="container">
			<div class="grid grid-cols-12 gap-8">
				<div class="col-span-12 md:col-span-6 xl:col-span-3">
					<div class="dif-item flex flex-row items-center gap-6">
						<div class="img-holder rounded-[5px] bg-white p-4">
							<img class="w-10 h-10" src="" alt="">
						</div>
						<h4 class="text-white">Atendimento humanizado e gentil</h4>
					</div>
				</div>
				<div class="col-span-12 md:col-span-6 xl:col-span-3">
					<div class="dif-item flex flex-row items-center gap-6">
						<div class="img-holder rounded-[5px] bg-white p-4">
							<img class="w-10 h-10" src="" alt="">
						</div>
						<h4 class="text-white">Atendimento humanizado e gentil</h4>
					</div>
				</div>
				<div class="col-span-12 md:col-span-6 xl:col-span-3">
					<div class="dif-item flex flex-row items-center gap-6">
						<div class="img-holder rounded-[5px] bg-white p-4">
							<img class="w-10 h-10" src="" alt="">
						</div>
						<h4 class="text-white">Atendimento humanizado e gentil</h4>
					</div>
				</div>
				<div class="col-span-12 md:col-span-6 xl:col-span-3">
					<div class="dif-item flex flex-row items-center gap-6">
						<div class="img-holder rounded-[5px] bg-white p-4">
							<img class="w-10 h-10" src="" alt="">
						</div>
						<h4 class="text-white">Atendimento humanizado e gentil</h4>
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