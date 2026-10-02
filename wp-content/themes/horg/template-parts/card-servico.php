<?php
/**
 * Card de serviço.
 *
 * @param array $args {
 *     @type int $post_id ID do post. Default: post atual do loop.
 * }
 *
 * @package AlfamaWeb
 */

defined('ABSPATH') || exit;

$post_id = (int) ($args['post_id'] ?? get_the_ID());

if (!$post_id) {
	return;
}

$icone = get_field('icone', $post_id);
?>
<article class="card card-servico border-none">
	<div class="card-thumb">
		<img src="<?php echo esc_url(aw_thumb($post_id)); ?>" alt="" width="720" height="480" loading="lazy"
			decoding="async">
	</div>
	<div class="card-body">
		<div class="card-titulo inline-flex items-center gap-2">
			<?php if (!empty($icone['url'])) : ?>
				<img src="<?php echo esc_url($icone['url']); ?>" alt="<?php echo esc_attr($icone['alt'] ?? ''); ?>">
			<?php endif; ?>
			<h4 class="font-bold"><?php echo esc_html(get_the_title($post_id)); ?></h4>
		</div>
		<p class="card-resumo"><?php echo esc_html(aw_resumo($post_id)); ?></p>
	</div>
</article>
