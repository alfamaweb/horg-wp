<?php
/**
 * Template Name: Home
 *
 * Home de referência: hero em swiper e CTA. Os campos vêm do grupo ACF "Home";
 * enquanto não existirem, os componentes exibem placeholder visível em vez de
 * quebrar.
 *
 * @package AlfamaWeb
 */

defined('ABSPATH') || exit;

get_header();

$slides = get_field('home_slides');
?>
<main id="conteudo">

	<section class="hero-home" aria-label="<?php esc_attr_e('Destaques', 'alfama-web'); ?>">
		<?php if (is_array($slides) && $slides): ?>
			<div class="swiper hero-swiper"
				data-aw-swiper='{"loop":true,"autoplay":{"delay":6000},"pagination":{"el":".hero-swiper .swiper-pagination","clickable":true}}'>
				<div class="swiper-wrapper">
					<?php foreach ($slides as $slide):
						$imagem = $slide['desktop'] ?? array();
						$titulo = $slide['titulo'] ?? '';
						$texto = $slide['texto'] ?? '';
						$botao = $slide['botao'] ?? '';
						$url = $slide['url'] ?? '';
						?>
						<div class="swiper-slide">
							<?php if (!empty($imagem['url'])):
								$imagem_mobile = $slide['mobile'] ?? array(); ?>
								<picture>
									<?php if (!empty($imagem_mobile['url'])): ?>
										<source media="(max-width: 767px)" srcset="<?php echo esc_url($imagem_mobile['url']); ?>">
									<?php endif; ?>
									<img src="<?php echo esc_url($imagem['url']); ?>"
										alt="<?php echo esc_attr($imagem['alt'] ?? ''); ?>" class="hero-img max-h-116 lg:max-h-156"
										loading="eager" fetchpriority="high">
								</picture>
							<?php else: ?>
								<div class="aw-placeholder hero-img">[
									<?php esc_html_e('imagem do slide — custom field', 'alfama-web'); ?> ]
								</div>
							<?php endif; ?>

							<div class="hero-content h-full content-center">
								<div class="container">
									<div class="grid grid-cols-12">
										<div class="col-span-12 md:col-span-8 xl:col-span-6">
											<?php if (!empty($slide['eyebrow'])): ?>
												<div class="hero-eyebrow"><?php echo esc_html($slide['eyebrow']); ?></div>
											<?php endif; ?>
											<h2 class="hero-titulo"><?php echo wp_kses_post($titulo); ?></h2>
											<div class="aw-prose-invertido"><?php echo wp_kses_post($texto); ?></div>
											<?php if ($url): ?>
												<a href="<?php echo esc_url($url); ?>" class="btn mt-[30px]">
													<?= esc_html($botao); ?>
												</a>
											<?php endif; ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="swiper-pagination"></div>
			</div>
		<?php else: ?>
			<?php get_template_part('template-parts/hero', null, array(
				'title' => get_bloginfo('name'),
				'text' => get_bloginfo('description'),
			)); ?>
		<?php endif; ?>
	</section>
	<?php
	if (have_rows('diferenciais')):

		?>
		<section class="max-lg:my-10 lg:mt-0" id="hero-dif">
			<div class="container">
				<div class="holder bg-degrade max-lg:rounded-[15px] lg:rounded-b-[15px] py-6 px-10 2xl:py-11 2xl:px-20">
					<div class="flex justify-between max-lg:flex-col lg:flex-nowrap gap-6 xl:gap-8">
						<?php
						while (have_rows('diferenciais')):
							the_row();
							$icone = get_sub_field('icone');
							$texto = get_sub_field('texto');
							?>
							<div class="flex flex-row flex-nowrap items-center lg:max-w-md gap-3">
								<div class="icon-holder bg-white aspect-square rounded-[5px] p-4">
									<img class="max-h-7 max-w-7 lg:min-h-10 lg:min-w-10 aspect-square object-contain"
										src="<?php echo esc_url($icone['url'] ?? ''); ?>"
										alt="<?php echo esc_attr($icone['alt'] ?? ''); ?>">
								</div>
								<div class="txt font-roboto text-xl leading-[1.2] xl:text-[28px] text-white">
									<?php echo wp_kses_post($texto); ?>
								</div>
							</div>
							<?php
						endwhile;
						?>
					</div>
				</div>
			</div>
		</section>
		<?php
	endif;
	?>
	<?php
	$servicos_selecionados = array_filter(array_map(
		static function ($servico) {
			return $servico instanceof WP_Post ? $servico->ID : (int) $servico;
		},
		(array) get_field('servicos')
	));

	if ($servicos_selecionados) {
		// Seleção manual no campo "Serviços" da Home, na ordem escolhida.
		$servicos_query = new WP_Query(array(
			'post_type'           => 'servico',
			'post_status'         => 'publish',
			'post__in'            => $servicos_selecionados,
			'orderby'             => 'post__in',
			'posts_per_page'      => count($servicos_selecionados),
			'ignore_sticky_posts' => true,
		));
	} else {
		$servicos_home  = new AW_Query_Service('servico', array(), array(
			'por_pagina' => 4,
			'orderby'    => 'menu_order date',
			'order'      => 'ASC',
		));
		$servicos_query = $servicos_home->query();
	}
	?>
	<?php if ($servicos_query->have_posts()) : ?>
		<section id="servicos">
			<div class="container">
				<div class="section-title">
					<div class="eyebrow mb-3"><?php echo esc_html(get_field('servicos_eyebrow') ?: 'Principais Serviços'); ?></div>
					<h2><?php echo esc_html(get_field('servicos_titulo') ?: 'O que fazemos por você'); ?></h2>
					<div class="line max-w-[200px]"></div>
				</div>
				<?php // Carrossel no mobile (Figma Mobile), 4 colunas no desktop. ?>
				<div class="swiper servicos-swiper"
					data-aw-swiper='{"slidesPerView":1.08,"spaceBetween":20,"breakpoints":{"768":{"slidesPerView":2,"spaceBetween":30},"1200":{"slidesPerView":4,"spaceBetween":30}}}'>
					<div class="swiper-wrapper">
						<?php while ($servicos_query->have_posts()) : $servicos_query->the_post(); ?>
							<div class="swiper-slide !h-auto">
								<?php get_template_part('template-parts/card-servico', null, array('post_id' => get_the_ID())); ?>
							</div>
						<?php endwhile; ?>
					</div>
				</div>
				<?php wp_reset_postdata(); ?>
			</div>
		</section>
	<?php endif; ?>

	<section class="max-lg:bg-[#EDF5FF] max-lg:py-5" id="atendimento">
		<div class="container">
			<div class="holder rounded-3xl bg-[#EDF5FF] py-8 lg:p-12">
				<div class="section-title text-center mb-10">
					<div class="eyebrow mb-3"><?php echo esc_html(get_field('atendimento_eyebrow') ?: 'Atendimento Personalizado'); ?></div>
					<h2><?php echo esc_html(get_field('atendimento_titulo') ?: 'Conte com a nossa experiência'); ?></h2>
					<div class="line max-w-[300px]"></div>
				</div>
				<?php
				$atendimento_imagem = get_field('atendimento_imagem');
				$atendimento_video  = get_field('atendimento_video');
				?>
				<div class="relative mx-auto max-w-300">
					<img class="mx-auto rounded-[15px] max-lg:aspect-[3/2] h-full object-cover"
						src="<?php echo esc_url($atendimento_imagem['url'] ?? 'https://placehold.co/1156x520'); ?>"
						alt="<?php echo esc_attr($atendimento_imagem['alt'] ?? ''); ?>">
					<?php if ($atendimento_video): ?>
						<a href="<?php echo esc_url($atendimento_video); ?>"
							target="_blank" rel="noopener"
							class="absolute inset-0 left-1/2 top-1/2 -translate-1/2 bg-[#D9E7F780] rounded-[15px] cursor-pointer w-12 h-12 lg:w-25 lg:h-25 z-1">
							<span class="sr-only"><?php esc_html_e('Assistir ao vídeo', 'alfama-web'); ?></span>
							<img src="<?= IMG_URI ?>play.svg" alt="" aria-hidden="true"
								class="absolute inset-0 left-1/2 top-1/2 -translate-1/2 w-6 h-6 lg:w-15 lg:h-15">
						</a>
					<?php endif; ?>
				</div>
				<?php aw_botao(get_field('atendimento_botao'), __('Agende sua consulta', 'alfama-web'), 'btn escuro mx-auto mt-10'); ?>
			</div>
		</div>
	</section>

	<section class="relative" id="welcome">
		<div class="absolute bg-degrade w-86 h-86 left-0 rounded-r-[15px] -z-1"></div>
		<div class="container z-1">
			<div class="flex flex-col lg:grid grid-cols-12 gap-8 pt-12">
				<?php $welcome_imagem = get_field('welcome_imagem'); ?>
				<div class="3xl:col-start-2 col-span-6 3xl:col-span-5">
					<img class="rounded-[15px] w-full h-full object-cover"
						src="<?php echo esc_url($welcome_imagem['url'] ?? 'https://placehold.co/674x406'); ?>"
						alt="<?php echo esc_attr($welcome_imagem['alt'] ?? 'Welcome Image'); ?>">
				</div>
				<div class="col-span-6">
					<div class="section-title items-start max-lg:items-center max-lg:text-center">
						<div class="eyebrow mb-3"><?php echo esc_html(get_field('welcome_eyebrow') ?: 'Bem-vindo à Horg'); ?></div>
						<h2><?php echo esc_html(get_field('welcome_titulo') ?: 'Excelência em cuidado com a sua visão'); ?></h2>
						<div class="line max-w-[200px] mb-8"></div>
						<?php
						$welcome_texto = get_field('welcome_texto');
						if ($welcome_texto):
							echo wp_kses_post($welcome_texto);
						else:
							?>
							<p>Na Horg, acreditamos que enxergar bem é viver melhor. Por isso, nossa missão vai muito além do
								cuidado com os olhos — queremos cuidar de você por completo, com atenção, empatia e dedicação em
								cada atendimento. Somos uma clínica oftalmológica formada por uma equipe especializada,
								apaixonada pelo que faz e comprometida com o bem-estar de cada paciente.

								Aqui, você encontra um ambiente acolhedor, seguro e feito para que você se sinta confortável
								desde o primeiro contato. Seja para um simples exame de rotina ou um tratamento mais específico,
								estaremos ao seu lado em cada passo, com profissionalismo e cuidado genuíno.</p>
						<?php endif; ?>
					</div>
					<?php
					$pagina_sobre = get_page_by_path('sobre');
					aw_botao(get_field('welcome_botao'), __('Sobre a Horg', 'alfama-web'), 'btn escuro mt-10 max-lg:mx-auto', array(
						'url'    => $pagina_sobre ? get_permalink($pagina_sobre) : home_url('/sobre'),
						'title'  => '',
						'target' => '',
					));
					?>
				</div>
			</div>
		</div>
	</section>

	<section class="relative lg:h-100 overflow-hidden" id="depoimentos">
		<div class="absolute bg-cinza-claro lg:100 xl:w-150 3xl:w-200 h-100 right-0 rounded-l-[15px] -z-1"></div>
		<div class="container h-full">
			<div class="flex flex-col lg:grid grid-cols-12 gap-8 pt-12">
				<div class="col-span-6 content-center">
					<div class="section-title max-lg:text-center lg:items-start mb-10">
						<div class="eyebrow mb-3"><?php echo esc_html(get_field('depoimentos_eyebrow') ?: 'Depoimentos'); ?></div>
						<h2><?php echo esc_html(get_field('depoimentos_titulo') ?: 'O que nossos pacientes dizem'); ?></h2>
						<div class="line max-w-[300px] mb-10"></div>
						<?php
						$depoimentos_texto = get_field('depoimentos_texto');
						if ($depoimentos_texto):
							echo wp_kses_post($depoimentos_texto);
						else:
							?>
							<p>Nada melhor do que ouvir de quem já viveu a experiência. Na Horg, cada paciente é recebido
								com carinho, atenção e aquele cuidado especial que faz toda a diferença.</p>
						<?php endif; ?>
					</div>
					<div class="custom-navs flex items-center gap-5 max-lg:justify-center">
						<button type="button" class="btn-prev depoimentos-prev bg-azul rounded-[5px] w-15 h-15"><span class="sr-only"><?php esc_html_e('Depoimento anterior', 'alfama-web'); ?></span></button>
						<button type="button" class="btn-next depoimentos-next bg-azul rounded-[5px] w-15 h-15"><span class="sr-only"><?php esc_html_e('Próximo depoimento', 'alfama-web'); ?></span></button>
					</div>
				</div>
				<div class="col-span-6 content-center">
					<div class="swiper depoimentos-swiper !overflow-visible">
						<div class="swiper-wrapper pb-8">
							<?php if (have_rows('depoimentos')): ?>
								<?php while (have_rows('depoimentos')): the_row();
									$depoimento_titulo    = get_sub_field('titulo');
									$depoimento_subtitulo = get_sub_field('subtitulo');
									$depoimento_texto     = get_sub_field('texto');
									$depoimento_nota      = max(0, min(5, (int) get_sub_field('nota')));
									$depoimento_foto      = get_sub_field('foto');
									?>
									<div class="swiper-slide">
										<div class="card p-[30px] rounded-[20px] border-0">
											<div class="flex items-center gap-4 mb-6">
												<?php if (!empty($depoimento_foto['url'])): ?>
													<img src="<?php echo esc_url($depoimento_foto['sizes']['thumbnail'] ?? $depoimento_foto['url']); ?>"
														alt="<?php echo esc_attr($depoimento_titulo); ?>" class="w-[111px] h-[88px] rounded-[10px] object-cover shrink-0" loading="lazy">
												<?php endif; ?>
												<div>
													<div class="depoimento-nome"><?php echo esc_html($depoimento_titulo); ?></div>
													<?php if ($depoimento_subtitulo): ?>
														<div class="depoimento-subtitulo"><?php echo esc_html($depoimento_subtitulo); ?></div>
													<?php endif; ?>
													<?php if ($depoimento_nota): ?>
														<div class="flex gap-1 mt-3 text-[#ffc107]" role="img"
															aria-label="<?php echo esc_attr(sprintf(__('Nota %d de 5', 'alfama-web'), $depoimento_nota)); ?>">
															<?php for ($estrela = 1; $estrela <= 5; $estrela++): ?>
																<svg class="w-[22px] h-[18px] <?php echo $estrela > $depoimento_nota ? 'opacity-25' : ''; ?>" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
																	<path d="M12 2.5l2.9 6.1 6.6.8-4.9 4.6 1.3 6.6L12 17.3l-5.9 3.3 1.3-6.6-4.9-4.6 6.6-.8z" />
																</svg>
															<?php endfor; ?>
														</div>
													<?php endif; ?>
												</div>
											</div>
											<div class="depoimento-texto"><?php echo wp_kses_post($depoimento_texto); ?></div>
										</div>
									</div>
								<?php endwhile; ?>
							<?php else: ?>
								<div class="swiper-slide">
									<div class="card p-6 rounded-[15px]">
										<p class="card-resumo text-cinza">"Excelente atendimento! A equipe da Horg é muito
											profissional
											e atenciosa. Me senti acolhido desde o primeiro contato."</p>
										<div class="mt-4 font-bold">João Silva</div>
									</div>
								</div>
								<div class="swiper-slide">
									<div class="card p-6 rounded-[15px]">
										<p class="card-resumo text-cinza">"Recomendo a Horg a todos! O cuidado com os
											pacientes é
											excepcional e os resultados dos tratamentos são ótimos."</p>
										<div class="mt-4 font-bold">Maria Oliveira</div>
									</div>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
	</section>

	<?php
	$artigos_home  = new AW_Query_Service('post', array(), array(
		'por_pagina' => 3,
		'orderby'    => 'date',
		'order'      => 'DESC',
	));
	$artigos_query = $artigos_home->query();
	?>
	<?php if ($artigos_query->have_posts()) : ?>
		<section id="artigos">
			<div class="container">
				<div class="section-title text-center">
					<div class="eyebrow mb-3"><?php echo esc_html(get_field('artigos_eyebrow') ?: 'Artigos Publicados'); ?></div>
					<h2><?php echo esc_html(get_field('artigos_titulo') ?: 'Aprendizados e curiosidades oftalmológicas'); ?></h2>
					<div class="line max-w-[200px]"></div>
				</div>
				<div class="swiper artigos-swiper"
					data-aw-swiper='{"slidesPerView":1.08,"spaceBetween":20,"breakpoints":{"768":{"slidesPerView":2,"spaceBetween":30},"992":{"slidesPerView":3,"spaceBetween":31}}}'>
					<div class="swiper-wrapper">
						<?php while ($artigos_query->have_posts()) : $artigos_query->the_post(); ?>
							<div class="swiper-slide !h-auto">
								<?php get_template_part('template-parts/card-artigo', null, array('post_id' => get_the_ID())); ?>
							</div>
						<?php endwhile; ?>
					</div>
				</div>
				<?php wp_reset_postdata(); ?>
				<?php $pagina_artigos = get_page_by_path('artigos'); ?>
				<a href="<?php echo esc_url($pagina_artigos ? get_permalink($pagina_artigos) : home_url('/artigos')); ?>"
					class="btn escuro mt-10 mx-auto">Ver todos os artigos</a>
			</div>
		</section>
	<?php endif; ?>

	<?php get_template_part('template-parts/cta-agendamento'); ?>
</main>
<?php
get_footer();
?>
<script>
	document.addEventListener('DOMContentLoaded', function () {
		const swiper = new Swiper('.depoimentos-swiper', {
			loop: false,
			autoplay: {
				delay: 6000,
			},
			slidesPerView: 1,
			spaceBetween: 20,
			navigation: {
				prevEl: '.depoimentos-prev',
				nextEl: '.depoimentos-next',
			},
			breakpoints: {
				992: { slidesPerView: 2, spaceBetween: 53 },
			},
		});

	});
</script>