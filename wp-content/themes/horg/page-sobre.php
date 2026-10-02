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
						<div class="eyebrow mb-3 lg:mb-4"><?php echo esc_html(get_field('sobre_eyebrow') ?: 'sobre nós'); ?></div>
						<h2><?php echo esc_html(get_field('sobre_titulo') ?: 'O Hospital de Olhos Rollemberg Gois'); ?></h2>
						<div class="line max-w-[200px]"></div>
					</div>
					<?php if ($sobre_texto = get_field('sobre_texto')): ?>
						<div class="aw-prose mt-8"><?php echo wp_kses_post($sobre_texto); ?></div>
					<?php endif; ?>
				</div>
				<?php $sobre_imagem = get_field('sobre_imagem'); ?>
				<div class="col-span-12 lg:col-span-6">
					<div class="relative isolate h-full pl-6 lg:pl-10">
						<div class="absolute bg-degrade left-0 top-[18%] w-[35%] h-[64%] rounded-l-[20px] -z-1" aria-hidden="true"></div>
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
				<?php if (have_rows('mvv')): ?>
					<?php while (have_rows('mvv')): the_row();
						$mvv_titulo = get_sub_field('titulo');
						$mvv_texto  = get_sub_field('texto');
						?>
						<div class="col-span-12 lg:col-span-4">
							<div class="card !drop-shadow-sombra-1 px-6 py-8">
								<div class="section-title items-center text-center">
									<h3><?php echo esc_html($mvv_titulo); ?></h3>
									<div class="line max-w-[200px]"></div>
									<?php if ($mvv_texto): ?>
										<?php echo wp_kses_post($mvv_texto); ?>
									<?php endif; ?>
								</div>
							</div>
						</div>
					<?php endwhile; ?>
				<?php else: ?>
					<div class="col-span-12 lg:col-span-4">
						<div class="card !drop-shadow-sombra-1 px-6 py-8">
							<div class="section-title items-center text-center">
								<h3>Missão</h3>
								<div class="line max-w-[200px]"></div>
							</div>
						</div>
					</div>
					<div class="col-span-12 lg:col-span-4">
						<div class="card !drop-shadow-sombra-1 px-6 py-8">
							<div class="section-title items-center text-center">
								<h3>Visão</h3>
								<div class="line max-w-[200px]"></div>
							</div>
						</div>
					</div>
					<div class="col-span-12 lg:col-span-4">
						<div class="card !drop-shadow-sombra-1 px-6 py-8">
							<div class="section-title items-center text-center">
								<h3>Valores</h3>
								<div class="line max-w-[200px]"></div>
							</div>
						</div>
					</div>
				<?php endif; ?>
			</div>
	</section>

	<section id="equipe">
		<div class="container">
			<div class="flex flex-row justify-between items-end mb-11">
				<div class="section-title items-start text-start mb-0">
					<div class="eyebrow mb-3 lg:mb-4"><?php echo esc_html(get_field('equipe_eyebrow') ?: 'Nossa equipe'); ?></div>
					<h2><?php echo esc_html(get_field('equipe_titulo') ?: 'Profissionais que cuidam de você'); ?></h2>
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
					<?php if (have_rows('equipe')): ?>
						<?php while (have_rows('equipe')): the_row();
							$equipe_membro_titulo = get_sub_field('titulo');
							$equipe_membro_texto  = get_sub_field('texto');
							?>
							<div class="swiper-slide">
								<div class="card p-8 rounded-[10px] bg-azul text-white">
									<div class="flex flex-col items-start gap-6 lg:gap-8">
										<img src="<?= IMG_URI ?>bx_health.svg" alt="Medico" class="w-6 h-6">
										<h3><?php echo esc_html($equipe_membro_titulo); ?></h3>
										<div class="uppercase text-2xl leading-[160%]"><?php echo esc_html($equipe_membro_texto); ?></div>
									</div>
								</div>
							</div>
						<?php endwhile; ?>
					<?php else: ?>
						<div class="swiper-slide">
							<div class="card p-8 rounded-[10px] bg-azul text-white">
								<div class="flex flex-col items-start gap-6 lg:gap-8">
									<img src="<?= IMG_URI ?>bx_health.svg" alt="Medico" class="w-6 h-6">
									<h3>JOÃO VITOR SANTANA DANTAS</h3>
									<div class="uppercase text-2xl leading-[160%]">MÉDICO ANESTESISTA - CRM 8362</div>
								</div>
							</div>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>

	<section id="equipamentos">
		<div class="container">
			<div class="grid grid-cols-12 gap-8">
				<?php $equipamentos_imagem = get_field('equipamentos_imagem'); ?>
				<div class="col-span-12 lg:col-span-6">
					<div class="relative isolate h-full pr-6 lg:pr-10">
						<div class="absolute bg-degrade right-0 top-[20%] w-[35%] h-[59%] rounded-r-[20px] -z-1" aria-hidden="true"></div>
						<img src="<?php echo esc_url($equipamentos_imagem['url'] ?? 'https://placehold.co/775x428'); ?>"
							alt="<?php echo esc_attr($equipamentos_imagem['alt'] ?? 'Equipamentos da Horg'); ?>" class="w-full h-full object-cover rounded-[15px]">
					</div>
				</div>
				<div class="col-span-12 lg:col-span-6">
					<div class="section-title items-start">
						<div class="eyebrow mb-3 lg:mb-4"><?php echo esc_html(get_field('equipamentos_eyebrow') ?: 'Equipamentos e tecnologia'); ?></div>
						<h2><?php echo esc_html(get_field('equipamentos_titulo') ?: 'Referência em Oftalmologia'); ?></h2>
						<div class="line max-w-[200px]"></div>
					</div>
					<?php if ($equipamentos_texto = get_field('equipamentos_texto')): ?>
						<div class="aw-prose mt-8"><?php echo wp_kses_post($equipamentos_texto); ?></div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>

	<?php get_template_part('template-parts/cta-agendamento'); ?>
</main>
<?php
get_footer();