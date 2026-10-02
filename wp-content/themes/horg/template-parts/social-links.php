<?php
/**
 * Redes sociais, cadastradas em Opções do Site.
 *
 * @param array $args {
 *     @type string $class Classes do <ul>. Default: 'flex items-center gap-3'.
 * }
 *
 * @package AlfamaWeb
 */

defined('ABSPATH') || exit;

$classe = $args['class'] ?? 'flex items-center gap-3';
$redes  = aw_field('redes_sociais', 'option', array());

if (!is_array($redes)) {
	$redes = array();
}

// O WhatsApp não entra aqui: ele já tem o botão flutuante e o número no
// bloco "Telefones" do rodapé.
if (!$redes) {
	return;
}
?>
<ul class="social-links <?php echo esc_attr($classe); ?>">
	<?php foreach ($redes as $rede) :
		if (empty($rede['url'])) {
			continue;
		}
		?>
		<li>
			<a href="<?php echo esc_url($rede['url']); ?>" target="_blank" rel="noopener noreferrer">
				<span class="sr-only"><?php echo esc_html($rede['nome'] ?? __('Rede social', 'alfama-web')); ?></span>
				<?php if (!empty($rede['icone']['url'])) : ?>
					<img src="<?php echo esc_url($rede['icone']['url']); ?>" alt="" width="20" height="20" loading="lazy" aria-hidden="true">
				<?php else : ?>
					<span aria-hidden="true">↗</span>
				<?php endif; ?>
			</a>
		</li>
	<?php endforeach; ?>
</ul>
