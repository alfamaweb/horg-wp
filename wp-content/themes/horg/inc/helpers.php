<?php
/**
 * Helpers globais do tema. Sem hooks — só funções puras usadas em template.
 *
 * @package AlfamaWeb
 */

defined('ABSPATH') || exit;

/**
 * Lê um campo do ACF com fallback, sem quebrar se o plugin estiver inativo.
 *
 * Substitui o acesso direto a get_field() nos templates: permite montar o
 * layout antes de os campos existirem e evita fatal error num site sem ACF.
 *
 * @param string          $key      Nome do campo.
 * @param int|string|null $post_id  ID do post, 'option' para a página de opções.
 * @param mixed           $fallback Valor devolvido quando o campo está vazio.
 * @return mixed
 */
function aw_field($key, $post_id = null, $fallback = '')
{
	if (!function_exists('get_field')) {
		return $fallback;
	}

	$value = get_field($key, $post_id);

	return ($value === null || $value === '' || $value === array()) ? $fallback : $value;
}

/**
 * Mesmo contrato de aw_field(), para subcampos dentro de have_rows().
 */
function aw_sub_field($key, $fallback = '')
{
	if (!function_exists('get_sub_field')) {
		return $fallback;
	}

	$value = get_sub_field($key);

	return ($value === null || $value === '' || $value === array()) ? $fallback : $value;
}

/**
 * Imprime um SVG de assets/img/ inline, para permitir currentColor no CSS.
 *
 * Só lê de dentro de assets/img/ e recusa qualquer caminho que escape da
 * pasta (proteção contra path traversal caso o nome venha de campo editável).
 *
 * @param string $arquivo Nome do arquivo, ex. 'icone-whatsapp.svg'.
 * @param array  $attr    Atributos extras aplicados à tag <svg>, ex. ['class' => 'h-5 w-5'].
 * @return void
 */
function aw_svg($arquivo, $attr = array())
{
	$base = realpath(AW_DIR . '/assets/img');
	$path = realpath(AW_DIR . '/assets/img/' . ltrim($arquivo, '/'));

	if (!$base || !$path || strpos($path, $base) !== 0 || !is_file($path)) {
		return;
	}

	$svg = file_get_contents($path);

	if (!$svg) {
		return;
	}

	if ($attr) {
		$extra = '';
		foreach ($attr as $nome => $valor) {
			$extra .= sprintf(' %s="%s"', esc_attr($nome), esc_attr($valor));
		}
		$svg = preg_replace('/<svg\b/', '<svg' . $extra, $svg, 1);
	}

	echo wp_kses($svg, aw_svg_allowed_tags()); // phpcs:ignore WordPress.Security.EscapeOutput
}

/**
 * Tags e atributos permitidos ao imprimir SVG inline.
 *
 * @return array
 */
function aw_svg_allowed_tags()
{
	$attrs = array(
		'class' => true, 'id' => true, 'style' => true, 'fill' => true, 'stroke' => true,
		'stroke-width' => true, 'stroke-linecap' => true, 'stroke-linejoin' => true,
		'viewbox' => true, 'width' => true, 'height' => true, 'xmlns' => true,
		'aria-hidden' => true, 'aria-label' => true, 'role' => true, 'focusable' => true,
		'd' => true, 'x' => true, 'y' => true, 'x1' => true, 'y1' => true, 'x2' => true,
		'y2' => true, 'cx' => true, 'cy' => true, 'r' => true, 'rx' => true, 'ry' => true,
		'points' => true, 'transform' => true, 'opacity' => true, 'fill-rule' => true,
		'clip-rule' => true, 'offset' => true, 'stop-color' => true, 'gradientunits' => true,
	);

	return array(
		'svg' => $attrs, 'g' => $attrs, 'path' => $attrs, 'circle' => $attrs,
		'rect' => $attrs, 'line' => $attrs, 'polyline' => $attrs, 'polygon' => $attrs,
		'ellipse' => $attrs, 'defs' => $attrs, 'lineargradient' => $attrs,
		'radialgradient' => $attrs, 'stop' => $attrs, 'clippath' => $attrs, 'title' => $attrs,
	);
}

/**
 * Monta a URL de WhatsApp a partir do número cadastrado nas Opções do Site.
 *
 * @param string $formato 'link' (wa.me) ou 'api' (api.whatsapp.com, para o botão flutuante).
 * @param string $texto   Mensagem pré-preenchida, opcional.
 * @return string URL, ou string vazia se não houver número cadastrado.
 */
function aw_whatsapp_url($formato = 'link', $texto = '')
{
	$numero = preg_replace('/\D/', '', (string) aw_field('whatsapp_numero', 'option', ''));

	if (!$numero) {
		return '';
	}

	if ('api' === $formato) {
		return add_query_arg(
			array('phone' => $numero, 'text' => $texto ?: null),
			'https://api.whatsapp.com/send/'
		);
	}

	return 'https://wa.me/' . $numero . ($texto ? '?text=' . rawurlencode($texto) : '');
}

/**
 * Resumo curto e seguro do conteúdo, para cards.
 *
 * @param int|null $post_id
 * @param int      $limite Número de caracteres.
 * @return string
 */
function aw_resumo($post_id = null, $limite = 160)
{
	$post_id = $post_id ?: get_the_ID();
	$texto   = has_excerpt($post_id)
		? get_the_excerpt($post_id)
		: wp_strip_all_tags(get_post_field('post_content', $post_id));

	$texto = trim(preg_replace('/\s+/', ' ', $texto));

	return mb_strimwidth($texto, 0, $limite, '…');
}

/**
 * URL da imagem destacada com fallback para o placeholder do tema.
 *
 * @param int|null $post_id
 * @param string   $tamanho
 * @return string
 */
function aw_thumb($post_id = null, $tamanho = 'aw-card')
{
	$post_id = $post_id ?: get_the_ID();
	$url     = get_the_post_thumbnail_url($post_id, $tamanho);

	return $url ?: AW_IMG . 'placeholder.svg';
}

/**
 * Extrai provedor, ID, URL de embed e thumbnail de um link de YouTube ou Vimeo.
 *
 * Herdado do helper get_acf_oembed_data() da v2, agora sem depender do ACF e
 * com o resultado cacheado (a consulta à API pública do Vimeo é remota).
 *
 * @param string $url Link do vídeo, ou o iframe devolvido por um campo oEmbed.
 * @return array{provedor:string,id:string,embed:string,thumb:string}|null
 */
function aw_video_data($url)
{
	if (!$url) {
		return null;
	}

	// Campo oEmbed do ACF devolve o <iframe> inteiro; extrai o src.
	if (false !== strpos($url, '<iframe')) {
		preg_match('/src="([^"]+)"/', $url, $m);
		$url = $m[1] ?? '';
	}

	if (preg_match('#(?:youtube\.com/(?:watch\?v=|embed/)|youtu\.be/)([A-Za-z0-9_-]{11})#', $url, $m)) {
		return array(
			'provedor' => 'youtube',
			'id'       => $m[1],
			'embed'    => 'https://www.youtube.com/embed/' . $m[1] . '?autoplay=1&rel=0',
			'thumb'    => 'https://i.ytimg.com/vi/' . $m[1] . '/maxresdefault.jpg',
		);
	}

	if (preg_match('#vimeo\.com/(?:video/)?(\d+)#', $url, $m)) {
		$id    = $m[1];
		$chave = 'aw_vimeo_' . $id;
		$thumb = get_transient($chave);

		if (false === $thumb) {
			$thumb    = '';
			$resposta = wp_remote_get('https://vimeo.com/api/oembed.json?url=' . rawurlencode('https://vimeo.com/' . $id), array('timeout' => 5));

			if (!is_wp_error($resposta)) {
				$dados = json_decode(wp_remote_retrieve_body($resposta), true);
				$thumb = $dados['thumbnail_url'] ?? '';
			}

			set_transient($chave, $thumb, DAY_IN_SECONDS);
		}

		return array(
			'provedor' => 'vimeo',
			'id'       => $id,
			'embed'    => 'https://player.vimeo.com/video/' . $id . '?autoplay=1',
			'thumb'    => $thumb,
		);
	}

	return null;
}
