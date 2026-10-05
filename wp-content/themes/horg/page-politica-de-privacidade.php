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

	<?php $hero = aw_field('hero', get_the_ID(), array()); ?>
	<section>
		<div class="container">
			<div class="section-title items-start text-start">
				<div class="eyebrow mb-3"><?php echo esc_html(($hero['texto'] ?? '') ?: __('termos de uso', 'alfama-web')); ?></div>
				<h1><?php echo esc_html(($hero['titulo'] ?? '') ?: get_the_title()); ?></h1>
				<div class="line max-w-[200px]"></div>
			</div>
			<div class="aw-prose max-w-none">
				<?php
				while (have_posts()) {
					the_post();
					the_content();
				}
				?>
			</div>
		</div>
	</section>
</main>
<?php
get_footer();
