<?php
/**
 * Barra de compartilhamento (WhatsApp, Instagram, X).
 *
 * @param array $args {
 *     @type string $titulo Título compartilhado. Default: título do post atual.
 *     @type string $url    URL compartilhada. Default: permalink do post atual.
 * }
 *
 * @package AlfamaWeb
 */

defined('ABSPATH') || exit;

$args = wp_parse_args($args ?? array(), array(
	'titulo' => get_the_title(),
	'url'    => get_permalink(),
));

$titulo = $args['titulo'];
$url    = $args['url'];

// O Instagram não tem intent de compartilhamento por URL: aponta para o perfil
// cadastrado em Opções do Site, o mesmo usado em template-parts/social-links.
$instagram_url = '#';

foreach ((array) aw_field('redes_sociais', 'option', array()) as $rede_social) {
	if (!empty($rede_social['url']) && false !== stripos($rede_social['nome'] ?? '', 'instagram')) {
		$instagram_url = $rede_social['url'];
		break;
	}
}

$redes = array(
	'whatsapp' => array(
		'rotulo'  => __('Compartilhar no WhatsApp', 'alfama-web'),
		'url'     => 'https://api.whatsapp.com/send?text=' . rawurlencode($titulo . ' - ' . $url),
		'viewbox' => '0 0 28 28',
		'markup'  => '<path fill="currentColor" d="M22.2719 5.77507C23.3521 6.84482 24.2086 8.11887 24.7915 9.52297C25.3744 10.9271 25.672 12.4331 25.6669 13.9534C25.6669 20.3234 20.4753 25.5151 14.1053 25.5151C12.0636 25.5151 10.0803 24.9784 8.33026 23.9751L2.3336 25.6084L3.9436 19.4834C3.02193 17.7917 2.53193 15.8901 2.53193 13.9534C2.53193 7.5834 7.7236 2.39173 14.0936 2.39173C17.1853 2.39173 20.0903 3.5934 22.2719 5.77507ZM4.49193 13.9534C4.49193 15.6801 4.9586 17.3717 5.8336 18.8534L6.0436 19.2034L5.08693 22.8434L8.6336 21.8751L8.99526 22.1084C10.527 23.0679 12.2978 23.5773 14.1053 23.5784C19.4019 23.5784 23.7186 19.2617 23.7186 13.9651C23.7186 11.3984 22.7153 8.9834 20.8953 7.17507C20.0041 6.27951 18.944 5.56983 17.7764 5.08717C16.6088 4.60452 15.357 4.3585 14.0936 4.3634C8.79693 4.34007 4.49193 8.65673 4.49193 13.9534ZM11.6786 8.68007C11.8186 8.97173 12.5186 10.3951 12.6236 10.6517C12.7169 10.9201 12.7636 11.1067 12.4836 11.3051C12.1919 11.5034 11.5386 12.0517 11.3519 12.2151C11.1536 12.3784 11.1303 12.5534 11.2819 12.8451C11.4219 13.1367 11.7369 14.0701 12.7169 15.1667C13.4869 16.0301 14.4319 16.6017 14.7236 16.7767C15.0153 16.9401 15.1669 16.8001 15.3186 16.6484C15.4469 16.5201 15.6569 16.3567 15.8203 16.2167C15.9836 16.0767 16.1119 16.0184 16.2986 15.9251C16.4969 15.8317 16.6603 15.8784 16.8003 15.9484C16.9403 16.0184 18.3636 16.6017 18.9469 16.8351C19.5069 17.0684 19.4369 17.3134 19.4486 17.4884L19.4486 18.0484C19.4486 18.2467 19.3786 18.5501 19.0869 18.8184C18.7953 19.0751 18.0953 19.8217 16.6719 19.8217C15.2486 19.8217 13.8719 18.7834 13.6853 18.6434C13.4869 18.5034 10.5703 16.6017 9.32193 13.7084C9.0186 13.0201 8.8436 12.4834 8.71526 12.0634C8.4936 11.3751 8.5286 10.7451 8.5986 10.2434C8.68026 9.6834 9.2986 8.5284 9.97526 8.29507C10.6519 8.05007 11.2236 8.05007 11.3519 8.13173C11.4803 8.2134 11.5386 8.3884 11.6786 8.68007Z"/>',
	),
	'instagram' => array(
		'rotulo'  => __('Ver no Instagram', 'alfama-web'),
		'url'     => $instagram_url,
		'viewbox' => '0 0 32 32',
		'markup'  => '<path fill="none" stroke="currentColor" stroke-width="2.66667" d="M14.6667 28C9.63867 28 7.124 28 5.56267 26.4373C4.00133 24.8747 4 22.3613 4 17.3333L4 14.6667C4 9.63867 4 7.124 5.56267 5.56267C7.12533 4.00134 9.63867 4 14.6667 4L17.3333 4C22.3613 4 24.876 4 26.4373 5.56267C27.9987 7.12533 28 9.63867 28 14.6667L28 17.3333C28 22.3613 28 24.876 26.4373 26.4373C24.8747 27.9987 22.3613 28 17.3333 28L14.6667 28Z"/><path fill="currentColor" d="M12 10C12 8.89543 11.1046 8 10 8C8.89543 8 8 8.89543 8 10C8 11.1046 8.89543 12 10 12C11.1046 12 12 11.1046 12 10Z"/><path fill="none" stroke="currentColor" stroke-width="2.66667" d="M20 16C20 13.7909 18.2091 12 16 12C13.7909 12 12 13.7909 12 16C12 18.2091 13.7909 20 16 20C18.2091 20 20 18.2091 20 16Z"/>',
	),
	'x' => array(
		'rotulo'  => __('Compartilhar no X', 'alfama-web'),
		'url'     => 'https://twitter.com/intent/tweet?url=' . rawurlencode($url) . '&text=' . rawurlencode($titulo),
		'viewbox' => '0 0 25 23',
		'markup'  => '<path fill="currentColor" d="M5.3125 22.6571L1.47857 22.6571L9.85357 13.0607L-7.34019e-08 -3.78688e-05L7.71428 -3.85432e-05L13.7607 7.9196L20.6714 -3.96759e-05L24.5089 -4.00114e-05L15.5518 10.2678L25 22.6553L17.0893 22.6553L11.6321 15.4178L5.3125 22.6571ZM6.66071 2.29996L4.53571 2.29996L18.25 20.4767L20.5286 20.4767L6.66071 2.29996Z"/>',
	),
);
?>
<div class="aw-compartilhar">
	<p class="aw-compartilhar-titulo"><?php esc_html_e('Compartilhe esse artigo', 'alfama-web'); ?></p>

	<ul class="flex items-center gap-3">
		<?php foreach ($redes as $rede) : ?>
			<li>
				<a class="btn escuro !inline-flex !h-12 !w-12 !p-0"
					href="<?php echo esc_url($rede['url']); ?>" target="_blank" rel="noopener noreferrer">
					<span class="sr-only"><?php echo esc_html($rede['rotulo']); ?></span>
					<svg width="28" height="28" viewBox="<?php echo esc_attr($rede['viewbox']); ?>" aria-hidden="true">
						<?php echo $rede['markup']; // phpcs:ignore WordPress.Security.EscapeOutput -- markup fixo do tema, sem entrada de usuário ?>
					</svg>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
</div>
