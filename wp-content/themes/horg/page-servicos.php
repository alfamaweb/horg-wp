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

	<section id="exames">
		<div class="container">
			<div class="grid grid-cols-12 gap-8">
				<div class="col-span-12 lg:col-span-6 lg:flex lg:flex-col lg:justify-center">
					<div class="section-title items-start">
						<div class="eyebrow mb-3"><?php echo esc_html(get_field('exames_eyebrow') ?: 'exames e diagnósticos'); ?></div>
						<h2><?php echo esc_html(get_field('exames_titulo') ?: 'Cuidando da Sua Visão com Precisão'); ?></h2>
						<div class="line max-w-[200px]"></div>
					</div>
					<?php if ($exames_texto = get_field('exames_texto')): ?>
						<div class="aw-prose"><?php echo wp_kses_post($exames_texto); ?></div>
					<?php endif; ?>
				</div>
				<?php $exames_imagem = get_field('exames_imagem'); ?>
				<div class="col-span-12 lg:col-span-6 max-lg:order-first">
					<div class="relative isolate h-full pt-6 pr-6 lg:pt-11 lg:pr-10">
						<div class="absolute bg-degrade right-0 top-0 w-1/2 h-2/3 rounded-[15px] -z-1" aria-hidden="true"></div>
						<img src="<?php echo esc_url($exames_imagem['url'] ?? 'https://placehold.co/775x390'); ?>"
							alt="<?php echo esc_attr($exames_imagem['alt'] ?? 'Exames na Horg'); ?>" class="w-full h-full object-cover rounded-[15px]">
					</div>
				</div>
			</div>
			<?php if ($exames_lista = get_field('exames_lista')): ?>
				<div class="lista-destaque mt-[45px]">
					<span class="lista-destaque-icone" aria-hidden="true">
						<svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5M9 13h6M9 17h6M9 9h2"/></svg>
					</span>
					<p class="lista-destaque-texto"><?php echo esc_html($exames_lista); ?></p>
				</div>
			<?php endif; ?>
		</div>
	</section>

	<?php if (have_rows('tratamentos')): ?>
		<section class="bg-cinza-claro py-12 lg:py-[55px]" id="tratamentos">
			<div class="container">
				<div class="section-title mb-10">
					<div class="eyebrow mb-3"><?php echo esc_html(get_field('tratamentos_eyebrow') ?: 'tratamentos e intervenções'); ?></div>
					<h2><?php echo esc_html(get_field('tratamentos_titulo') ?: 'Conheça algumas das principais opções disponíveis'); ?></h2>
					<div class="line max-w-[300px]"></div>
				</div>
				<div class="grid grid-cols-12 gap-8">
					<?php while (have_rows('tratamentos')): the_row();
						$tratamento_icone  = get_sub_field('icone');
						$tratamento_titulo = get_sub_field('titulo');
						$tratamento_texto  = get_sub_field('texto');
						?>
						<div class="col-span-12 md:col-span-6 2xl:col-span-3">
							<div class="card card-tratamento h-full !drop-shadow-sombra-1 border-0 rounded-[10px] px-[33px] py-[40px]">
								<div class="flex flex-col items-start gap-6">
									<img src="<?php echo esc_url($tratamento_icone['url'] ?? (IMG_URI . 'bx_health.svg')); ?>"
										alt="<?php echo esc_attr($tratamento_icone['alt'] ?? ''); ?>" class="w-10 h-10 object-contain">
									<h3 class="uppercase"><?php echo esc_html($tratamento_titulo); ?></h3>
									<?php if ($tratamento_texto): ?>
										<p class="mt-6"><?php echo wp_kses($tratamento_texto, array('br' => array())); ?></p>
									<?php endif; ?>
								</div>
							</div>
						</div>
					<?php endwhile; ?>
				</div>
				<?php aw_botao(get_field('tratamentos_botao'), __('Agende sua consulta', 'alfama-web'), 'btn escuro mx-auto mt-10'); ?>
			</div>
		</section>
	<?php endif; ?>

	<section id="cirurgias">
		<div class="container">
			<div class="grid grid-cols-12 gap-8">
				<?php $cirurgias_imagem = get_field('cirurgias_imagem'); ?>
				<div class="col-span-12 lg:col-span-6">
					<div class="relative isolate h-full pt-6 pl-6 lg:pt-11 lg:pl-10">
						<div class="absolute bg-degrade left-0 top-0 w-1/2 h-2/3 rounded-[15px] -z-1" aria-hidden="true"></div>
						<img src="<?php echo esc_url($cirurgias_imagem['url'] ?? 'https://placehold.co/775x390'); ?>"
							alt="<?php echo esc_attr($cirurgias_imagem['alt'] ?? 'Cirurgias na Horg'); ?>" class="w-full h-full object-cover rounded-[15px]">
					</div>
				</div>
				<div class="col-span-12 lg:col-span-6 lg:flex lg:flex-col lg:justify-center">
					<div class="section-title items-start">
						<div class="eyebrow mb-3"><?php echo esc_html(get_field('cirurgias_eyebrow') ?: 'CIRURGIAS DISPONÍVEIS'); ?></div>
						<h2><?php echo esc_html(get_field('cirurgias_titulo') ?: 'Seu procedimento com mais segurança'); ?></h2>
						<div class="line max-w-[200px]"></div>
					</div>
					<?php if ($cirurgias_texto = get_field('cirurgias_texto')): ?>
						<div class="aw-prose"><?php echo wp_kses_post($cirurgias_texto); ?></div>
					<?php endif; ?>
				</div>
			</div>
			<?php if ($cirurgias_lista = get_field('cirurgias_lista')): ?>
				<div class="lista-destaque mt-[45px]">
					<span class="lista-destaque-icone" aria-hidden="true">
						<svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5M9 13h6M9 17h6M9 9h2"/></svg>
					</span>
					<p class="lista-destaque-texto"><?php echo esc_html($cirurgias_lista); ?></p>
				</div>
			<?php endif; ?>
		</div>
	</section>

	<section id="convenios">
		<div class="container">
			<div class="flex flex-row justify-between items-end mb-11">
				<div class="section-title items-start text-start mb-0">
					<div class="eyebrow mb-3"><?php echo esc_html(get_field('convenios_eyebrow') ?: 'Convênios Médicos'); ?></div>
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