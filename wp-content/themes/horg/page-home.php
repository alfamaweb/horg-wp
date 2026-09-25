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
							<?php if (!empty($imagem['url'])): ?>
								<img src="<?php echo esc_url($imagem['url']); ?>"
									alt="<?php echo esc_attr($imagem['alt'] ?? ''); ?>" class="hero-img max-h-116 lg:max-h-156"
									loading="eager" fetchpriority="high">
							<?php else: ?>
								<div class="aw-placeholder hero-img">[
									<?php esc_html_e('imagem do slide — custom field', 'alfama-web'); ?> ]
								</div>
							<?php endif; ?>

							<div class="hero-content h-full content-center">
								<div class="container">
									<div class="grid grid-cols-12">
										<div class="col-span-12 md:col-span-8 xl:col-span-6">
											<h2 class="hero-titulo"><?php echo wp_kses_post($titulo); ?></h2>
											<div class="aw-prose-invertido"><?php echo wp_kses_post($texto); ?></div>
											<?php if ($url): ?>
												<a href="<?php echo esc_url($url); ?>" class="btn mt-6">
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
								<div class="txt text-lg md:text-xl xl:text-2xl text-white">
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
	<section id="servicos">
		<div class="container">
			<div class="section-title">
				<div class="eyebrow mb-3 lg:mb-4">Principais Serviços</div>
				<h2>O que fazemos por você</h2>
				<div class="line max-w-[200px]"></div>
			</div>
			<div class="grid grid-cols-12">
				<div class="col-span-3">
					<div class="card">
						<div class="card-thumb">
							<img src="https://placehold.co/400x400" alt="Service Image">
						</div>
						<div class="card-body">
							<div class="card-titulo">

								<h3>Consultas</h3>
							</div>
							<p class="card-resumo">Consultas oftalmológicas em geral e consultas especializadas em
								catarata, retina e outros.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="max-lg:bg-[#EDF5FF] max-lg:py-5" id="atendimento">
		<div class="container">
			<div class="holder rounded-3xl bg-[#EDF5FF] py-8 lg:p-12">
				<div class="section-title text-center mb-10">
					<div class="eyebrow mb-3 lg:mb-4">Atendimento Personalizado</div>
					<h2>Conte com a nossa experiência</h2>
					<div class="line max-w-[300px]"></div>
				</div>
				<div class="relative mx-auto max-w-300">
					<img class="mx-auto rounded-[15px] max-lg:aspect-[3/2] h-full object-cover"
						src="https://placehold.co/1156x520" alt="">
					<div
						class="absolute inset-0 left-1/2 top-1/2 -translate-1/2 bg-[#D9E7F780] rounded-[15px] cursor-pointer w-12 h-12 lg:w-25 lg:h-25 z-1">
						<img src="<?= IMG_URI ?>play.svg" alt="Play"
							class="absolute inset-0 left-1/2 top-1/2 -translate-1/2 w-6 h-6 lg:w-15 lg:h-15">
					</div>
				</div>
				<a href="#" class="btn escuro mx-auto mt-10">Agende sua consulta</a>
			</div>
		</div>
	</section>

	<section class="relative" id="welcome">
		<div class="absolute bg-degrade w-86 h-86 left-0 rounded-r-[15px] -z-1"></div>
		<div class="container z-1">
			<div class="flex flex-col lg:grid grid-cols-12 gap-8 pt-12">
				<div class="3xl:col-start-2 col-span-6 3xl:col-span-5">
					<img class="rounded-[15px] w-full h-full object-cover" src="https://placehold.co/674x406"
						alt="Welcome Image">
				</div>
				<div class="col-span-6">
					<div class="section-title items-start max-lg:items-center max-lg:text-center">
						<div class="eyebrow mb-3 lg:mb-4">Bem-vindo à Horg</div>
						<h2>Excelência em cuidado com a sua visão</h2>
						<div class="line max-w-[200px] mb-8"></div>
						<p>Na Horg, acreditamos que enxergar bem é viver melhor. Por isso, nossa missão vai muito além do
							cuidado com os olhos — queremos cuidar de você por completo, com atenção, empatia e dedicação em
							cada atendimento. Somos uma clínica oftalmológica formada por uma equipe especializada,
							apaixonada pelo que faz e comprometida com o bem-estar de cada paciente.
	
							Aqui, você encontra um ambiente acolhedor, seguro e feito para que você se sinta confortável
							desde o primeiro contato. Seja para um simples exame de rotina ou um tratamento mais específico,
							estaremos ao seu lado em cada passo, com profissionalismo e cuidado genuíno.</p>
					</div>
					<a href="#" class="btn escuro mt-10 max-lg:mx-auto">Sobre a Horg</a>
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
						<div class="eyebrow mb-3 lg:mb-4">Depoimentos</div>
						<h2>O que nossos pacientes dizem</h2>
						<div class="line max-w-[300px] mb-10"></div>
						<p>Nada melhor do que ouvir de quem já viveu a experiência. Na Horg, cada paciente é recebido
							com carinho, atenção e aquele cuidado especial que faz toda a diferença.</p>
					</div>
				</div>
				<div class="col-span-6 content-center">
					<div class="swiper depoimentos-swiper !overflow-visible">
						<div class="swiper-wrapper pb-8">
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
							<div class="swiper-slide">
								<div class="card p-6 rounded-[15px]">
									<p class="card-resumo text-cinza">"Recomendo a Horg a todos! O cuidado com os
										pacientes é
										excepcional e os resultados dos tratamentos são ótimos."</p>
									<div class="mt-4 font-bold">Maria Oliveira</div>
								</div>
							</div>
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
					<div class="eyebrow mb-3 lg:mb-4">Artigos Publicados</div>
					<h2>Aprendizados e curiosidades oftalmológicas</h2>
					<div class="line max-w-[200px]"></div>
				</div>
				<div class="grid grid-cols-12 gap-8">
					<?php while ($artigos_query->have_posts()) : $artigos_query->the_post(); ?>
						<div class="col-span-12 md:col-span-6 lg:col-span-4">
							<?php get_template_part('template-parts/card-artigo', null, array('post_id' => get_the_ID())); ?>
						</div>
					<?php endwhile; ?>
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
			slidesPerView: 2,
			spaceBetween: 50,
		});

	});
</script>