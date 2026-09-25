<?php
/**
 * Ponto único de entrada AJAX do tema.
 *
 * DÍVIDAS RESOLVIDAS (v2):
 *  - nonce obrigatório em TODA ação, inclusive nas *_nopriv (metade dos temas
 *    da v2 lia $_POST direto em endpoints públicos);
 *  - resposta sempre por wp_send_json_success/error, nunca echo json_encode;
 *  - registro declarativo: uma ação por entrada no mapa, com a lista de
 *    taxonomias aceitas, para não haver handler lendo parâmetro arbitrário.
 *
 * @package AlfamaWeb
 */

defined('ABSPATH') || exit;

class AW_Ajax_Controller
{
	/** Nome do nonce, compartilhado com o wp_localize_script de inc/assets.php. */
	const NONCE = 'aw_ajax';

	/**
	 * Ações registradas: nome => callback público desta classe.
	 *
	 * @return array<string,callable>
	 */
	public static function acoes()
	{
		return apply_filters('aw_ajax_acoes', array(
			'aw_filtrar_posts' => array(__CLASS__, 'filtrar_posts'),
			'aw_termos_filhos' => array(__CLASS__, 'termos_filhos'),
		));
	}

	/**
	 * @return void
	 */
	public static function init()
	{
		foreach (self::acoes() as $acao => $callback) {
			add_action('wp_ajax_' . $acao, array(__CLASS__, 'despachar'));
			add_action('wp_ajax_nopriv_' . $acao, array(__CLASS__, 'despachar'));
		}
	}

	/**
	 * Verifica o nonce e encaminha para o callback da ação.
	 *
	 * @return void
	 */
	public static function despachar()
	{
		$acao = isset($_POST['action']) ? sanitize_key(wp_unslash($_POST['action'])) : '';

		if (!check_ajax_referer(self::NONCE, 'nonce', false)) {
			wp_send_json_error(array('mensagem' => __('Sessão expirada. Recarregue a página.', 'alfama-web')), 403);
		}

		$acoes = self::acoes();

		if (!isset($acoes[$acao]) || !is_callable($acoes[$acao])) {
			wp_send_json_error(array('mensagem' => __('Ação não reconhecida.', 'alfama-web')), 400);
		}

		call_user_func($acoes[$acao]);
	}

	/**
	 * Listagem filtrável de posts do blog.
	 *
	 * @return void
	 */
	public static function filtrar_posts()
	{
		$params = AW_Query_Service::sanitize(wp_unslash($_POST), array('category', 'post_tag'));

		$service = new AW_Query_Service('post', $params, array(
			'por_pagina' => 9,
			'orderby'    => 'date',
			'order'      => 'DESC',
		));

		wp_send_json_success(array(
			'cards'     => $service->render('template-parts/card-post'),
			'paginacao' => $service->paginacao(),
			'total'     => $service->total(),
		));
	}

	/**
	 * Termos filhos de um termo pai — o efeito cascata cidade → bairro.
	 *
	 * @return void
	 */
	public static function termos_filhos()
	{
		$taxonomia = isset($_POST['taxonomia']) ? sanitize_key(wp_unslash($_POST['taxonomia'])) : '';
		$pai       = isset($_POST['pai']) ? sanitize_title(wp_unslash($_POST['pai'])) : '';

		$permitidas = apply_filters('aw_taxonomias_cascata', array('localizacao'));

		if (!in_array($taxonomia, $permitidas, true) || !taxonomy_exists($taxonomia)) {
			wp_send_json_error(array('mensagem' => __('Taxonomia inválida.', 'alfama-web')), 400);
		}

		$termo_pai = $pai ? get_term_by('slug', $pai, $taxonomia) : null;

		if ($pai && !$termo_pai) {
			wp_send_json_success(array('termos' => array()));
		}

		$filhos = get_terms(array(
			'taxonomy'   => $taxonomia,
			'parent'     => $termo_pai ? (int) $termo_pai->term_id : 0,
			'hide_empty' => true,
		));

		if (is_wp_error($filhos)) {
			wp_send_json_error(array('mensagem' => __('Não foi possível carregar as opções.', 'alfama-web')), 500);
		}

		wp_send_json_success(array(
			'termos' => array_map(function ($termo) {
				return array(
					'slug'  => $termo->slug,
					'nome'  => $termo->name,
					'total' => (int) $termo->count,
				);
			}, $filhos),
		));
	}
}
