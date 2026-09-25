<?php
/**
 * Card de artigo relacionado, com selo de categoria e assinatura do autor.
 *
 * @param array $args {
 *     @type int    $post_id   ID do post. Default: post atual do loop.
 *     @type string $cta_label Texto do link de leitura. Default: "Ler artigo completo".
 * }
 *
 * @package AlfamaWeb
 */

defined('ABSPATH') || exit;

$args = wp_parse_args($args ?? array(), array(
	'post_id'   => get_the_ID(),
	'cta_label' => __('Ler artigo completo', 'alfama-web'),
));

$post_id = (int) $args['post_id'];

if (!$post_id) {
	return;
}

$categorias = get_the_category($post_id);
$categoria  = $categorias ? $categorias[0] : null;
$permalink  = get_permalink($post_id);
?>
<article class="card card-artigo">
	<div class="card-thumb">
		<a href="<?php echo esc_url($permalink); ?>" tabindex="-1" aria-hidden="true">
			<img src="<?php echo esc_url(aw_thumb($post_id)); ?>"
				alt="" width="720" height="480" loading="lazy" decoding="async">
		</a>

		<?php if ($categoria) : ?>
			<span class="card-tag"><?php echo esc_html($categoria->name); ?></span>
		<?php endif; ?>
	</div>

	<div class="card-body">
		<h3 class="card-titulo">
			<a href="<?php echo esc_url($permalink); ?>"><?php echo esc_html(get_the_title($post_id)); ?></a>
		</h3>

		<p class="card-byline">
			<?php printf(
				/* translators: 1: nome do autor, 2: data de publicação. */
				esc_html__('Escrito por %1$s, publicado dia %2$s', 'alfama-web'),
				'<span class="card-byline-destaque">' . esc_html(get_the_author_meta('display_name', (int) get_post_field('post_author', $post_id))) . '</span>',
				'<span class="card-byline-destaque">' . esc_html(get_the_date('d/m/Y', $post_id)) . '</span>'
			); ?>
		</p>

		<a href="<?php echo esc_url($permalink); ?>" class="btn-texto card-cta"><?php echo esc_html($args['cta_label']); ?></a>
	</div>
</article>
