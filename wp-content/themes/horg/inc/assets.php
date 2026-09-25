<?php
/**
 * Registro e enfileiramento de CSS e JS.
 *
 * DÍVIDAS RESOLVIDAS (v2):
 *  - libs não entram mais como <link>/<script> literais no header.php/footer.php:
 *    tudo passa por wp_enqueue_*, então dependências e ordem são explícitas;
 *  - jQuery 1.11.1 (2014) hardcoded no header saiu. O tema é vanilla JS; se um
 *    plugin precisar de jQuery, o WordPress carrega a própria versão dele;
 *  - Bootstrap saiu por completo (232 KB de CSS carregados em toda página);
 *  - Fancybox e SweetAlert2 só entram onde são usados, via aw_enqueue_lib()
 *    ou pelo filtro 'aw_libs_automaticas'. Swiper é global (praticamente
 *    toda página usa) — ver comentário em aw_registrar_assets();
 *  - todo asset local é versionado por filemtime — cache-busting sem editar
 *    número de versão à mão.
 *
 * @package AlfamaWeb
 */

defined('ABSPATH') || exit;

/**
 * Versões fixadas das bibliotecas de terceiros. Atualizar aqui, num só lugar.
 */
const AW_LIB_VERSIONS = array(
	'swiper'      => '12.0.2',
	'fancybox'    => '5.0.36',
	'sweetalert2' => '11.14.5',
);

/**
 * Versão de um asset local a partir do mtime do arquivo.
 *
 * @param string $relativo Caminho relativo à raiz do tema, ex. '/assets/css/style.css'.
 * @return string|false
 */
function aw_asset_version($relativo)
{
	$path = AW_DIR . $relativo;

	return file_exists($path) ? (string) filemtime($path) : AW_VERSION;
}

/**
 * Registra tudo e enfileira o que é global.
 *
 * Ordem da cascata, garantida por dependência (não por prioridade de hook):
 *   aw-base  →  aw-global  →  aw-{contexto}  →  aw-tailwind
 *
 * O Tailwind entra por último de propósito: como é só utilitários, precisa
 * vencer qualquer regra de mesma especificidade definida em aw-global ou nos
 * CSS de contexto.
 *
 * @return void
 */
add_action('wp_enqueue_scripts', 'aw_registrar_assets');
function aw_registrar_assets()
{
	/* --------------------------------------------------------------------
	 * Bibliotecas de terceiros. Fancybox e SweetAlert2 só são registradas
	 * (enfileiradas sob demanda); Swiper é global — ver comentário abaixo.
	 * ----------------------------------------------------------------- */
	$v = AW_LIB_VERSIONS;

	// Swiper é global (não fica atrás de aw_libs_do_contexto()/aw_enqueue_lib()):
	// virou dependência de praticamente toda página, então a lógica de só
	// carregar sob demanda deixou de compensar — e evita cada template ter
	// que se preocupar em pedir a lib a tempo do wp_head() imprimir o CSS.
	wp_enqueue_style('swiper', "https://cdn.jsdelivr.net/npm/swiper@{$v['swiper']}/swiper-bundle.min.css", array(), $v['swiper']);
	wp_enqueue_script('swiper', "https://cdn.jsdelivr.net/npm/swiper@{$v['swiper']}/swiper-bundle.min.js", array(), $v['swiper'], true);

	wp_register_style('fancybox', "https://cdn.jsdelivr.net/npm/@fancyapps/ui@{$v['fancybox']}/dist/fancybox/fancybox.css", array(), $v['fancybox']);
	wp_register_script('fancybox', "https://cdn.jsdelivr.net/npm/@fancyapps/ui@{$v['fancybox']}/dist/fancybox/fancybox.umd.js", array(), $v['fancybox'], true);

	wp_register_style('sweetalert2', "https://cdn.jsdelivr.net/npm/sweetalert2@{$v['sweetalert2']}/dist/sweetalert2.min.css", array(), $v['sweetalert2']);
	wp_register_script('sweetalert2', "https://cdn.jsdelivr.net/npm/sweetalert2@{$v['sweetalert2']}/dist/sweetalert2.all.min.js", array(), $v['sweetalert2'], true);

	/* --------------------------------------------------------------------
	 * CSS do tema.
	 * ----------------------------------------------------------------- */

	// style.css da raiz: cabeçalho do tema + reset + tokens de design.
	wp_enqueue_style('aw-base', get_stylesheet_uri(), array(), aw_asset_version('/style.css'));

	// @font-face da webfont local (assets/fonts/).
	wp_enqueue_style('aw-fonts', AW_CSS . 'fonts.css', array('aw-base'), aw_asset_version('/assets/css/fonts.css'));

	// CSS autoral global.
	wp_enqueue_style('aw-global', AW_CSS . 'style.css', array('aw-base'), aw_asset_version('/assets/css/style.css'));

	// CSS do contexto atual (um arquivo por página / por post type).
	foreach (aw_slugs_de_css() as $slug) {
		aw_enqueue_css_se_existir($slug);
	}

	// Utilitários do Tailwind, compilados por `npm run build`. Entra por
	// último para ter prioridade sobre aw-global e os CSS de contexto.
	if (file_exists(AW_DIR . '/assets/css/tailwind.css')) {
		wp_enqueue_style('aw-tailwind', AW_CSS . 'tailwind.css', array('aw-global'), aw_asset_version('/assets/css/tailwind.css'));
	} elseif (aw_is_dev() && current_user_can('manage_options')) {
		wp_add_inline_style('aw-base', '/* aw: assets/css/tailwind.css não existe — rode `npm run build` no tema. */');
	}

	/* --------------------------------------------------------------------
	 * JS do tema.
	 * ----------------------------------------------------------------- */
	wp_enqueue_script('aw-app', AW_JS . 'app.js', array(), aw_asset_version('/assets/js/app.js'), true);

	wp_localize_script('aw-app', 'AW', array(
		'ajaxUrl'  => admin_url('admin-ajax.php'),
		'nonce'    => wp_create_nonce(AW_Ajax_Controller::NONCE),
		'homeUrl'  => home_url('/'),
		'i18n'     => array(
			'erroGenerico' => __('Não foi possível concluir agora. Tente novamente em instantes.', 'alfama-web'),
			'semResultado' => __('Nenhum resultado encontrado.', 'alfama-web'),
		),
	));

	/* --------------------------------------------------------------------
	 * Libs automáticas por contexto. Um projeto ajusta pelo filtro em vez de
	 * editar este arquivo.
	 * ----------------------------------------------------------------- */
	$automaticas = apply_filters('aw_libs_automaticas', aw_libs_do_contexto());

	foreach ((array) $automaticas as $lib) {
		aw_enqueue_lib($lib);
	}
}

/**
 * Slugs de CSS que o contexto atual pede, na ordem em que devem carregar.
 *
 * Mantém a convenção da v2 — page-{slug}.php ↔ assets/css/{slug}.css — e
 * acrescenta os contextos de arquivo, busca e erro.
 *
 * @return string[]
 */
function aw_slugs_de_css()
{
	$slugs = array();

	if (is_front_page()) {
		$slugs[] = 'home';
	}

	if (is_home() && !is_front_page()) {
		$slugs[] = 'blog';
	}

	if (is_page()) {
		$slugs[] = (string) get_post_field('post_name', get_queried_object_id());
	}

	if (is_singular()) {
		$slugs[] = get_post_type();
	}

	if (is_post_type_archive() || is_tax() || is_category() || is_tag() || is_date() || is_author()) {
		$slugs[] = 'archive';

		if (is_post_type_archive()) {
			$slugs[] = get_query_var('post_type') . '-archive';
		}
	}

	if (is_search()) {
		$slugs[] = 'search';
	}

	if (is_404()) {
		$slugs[] = '404';
	}

	return array_values(array_unique(array_filter($slugs)));
}

/**
 * Enfileira assets/css/{slug}.css se o arquivo existir.
 *
 * @param string $slug
 * @return bool Se enfileirou.
 */
function aw_enqueue_css_se_existir($slug)
{
	$slug     = sanitize_file_name($slug);
	$relativo = '/assets/css/' . $slug . '.css';

	if (!$slug || !file_exists(AW_DIR . $relativo)) {
		return false;
	}

	$handle = 'aw-css-' . $slug;

	if (!wp_style_is($handle, 'enqueued')) {
		wp_enqueue_style($handle, AW_CSS . $slug . '.css', array('aw-global'), aw_asset_version($relativo));
	}

	return true;
}

/**
 * Bibliotecas que cada contexto costuma precisar.
 *
 * @return string[]
 */
function aw_libs_do_contexto()
{
	// Swiper saiu daqui: virou global em aw_registrar_assets(). Esta função
	// fica pronta pra próxima lib que só valer a pena carregar por contexto
	// (fancybox, sweetalert2 — hoje só chamadas via aw_enqueue_lib() manual).
	$libs = array();

	return $libs;
}

/**
 * Enfileira uma lib registrada (CSS + JS) pelo mesmo handle.
 *
 * Pode ser chamada de dentro de um template: o WordPress imprime assets
 * enfileirados tarde no rodapé.
 *
 * @param string $lib 'swiper' | 'fancybox' | 'sweetalert2'
 * @return void
 */
function aw_enqueue_lib($lib)
{
	if (!array_key_exists($lib, AW_LIB_VERSIONS)) {
		return;
	}

	if (wp_style_is($lib, 'registered')) {
		wp_enqueue_style($lib);
	}

	if (wp_script_is($lib, 'registered')) {
		wp_enqueue_script($lib);
	}
}

/**
 * CSS do editor de blocos, para o conteúdo no admin lembrar o front.
 *
 * @return void
 */
add_action('after_setup_theme', 'aw_editor_style');
function aw_editor_style()
{
	add_theme_support('editor-styles');

	if (file_exists(AW_DIR . '/assets/css/editor.css')) {
		add_editor_style('assets/css/editor.css');
	}
}

/**
 * Preconecta a variante 400 da webfont: é a mais usada (corpo de texto) e,
 * sem isso, o navegador só a descobre depois de baixar e ler o CSS inteiro.
 *
 * @return void
 */
add_action('wp_head', 'aw_preload_fonte', 1);
function aw_preload_fonte()
{
	$fonte = '/assets/fonts/inter-v20-latin-400.woff2';

	if (!file_exists(AW_DIR . $fonte)) {
		return;
	}

	printf(
		'<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n",
		esc_url(AW_URI . $fonte)
	);
}
