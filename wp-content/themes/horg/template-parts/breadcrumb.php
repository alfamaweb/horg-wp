<?php
/**
 * Barra de breadcrumb "HOME > página atual".
 *
 * @param array $args {
 *     @type string $titulo Rótulo do segundo nível. Default: título da página atual.
 * }
 *
 * @package AlfamaWeb
 */

defined('ABSPATH') || exit;

$args = wp_parse_args($args ?? array(), array(
	'titulo' => get_the_title(),
	'margem' => is_single() ? '' : 'mb-23',
));
?>
<section class="<?php echo esc_attr($args['margem']); ?>">
	<div class="bg-cinza-claro py-5">
		<div class="container">
			<nav class="aw-breadcrumb" aria-label="<?php esc_attr_e('Você está aqui', 'alfama-web'); ?>">
				<a class="font-semibold"
					href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('HOME', 'alfama-web'); ?></a>
				<span class="font-semibold" aria-hidden="true">></span>
				<span class="uppercase text-azul font-bold"><?php echo esc_html($args['titulo']); ?></span>
			</nav>
		</div>
	</div>
</section>
