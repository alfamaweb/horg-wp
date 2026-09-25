<?php
/**
 * Desativa comentários por completo: front-end, admin e REST API.
 *
 * O tema não usa comentários em nenhum template. Em vez de só ocultar o
 * formulário, removemos o suporte dos post types, fechamos o que já existe
 * e tiramos toda a UI do admin (menu, barra superior, dashboard, colunas).
 *
 * @package AlfamaWeb
 */

defined('ABSPATH') || exit;

/**
 * Remove o suporte a comentários e trackbacks de todos os post types.
 *
 * @return void
 */
add_action('init', 'aw_remover_suporte_comentarios', 100);
function aw_remover_suporte_comentarios()
{
	foreach (get_post_types() as $post_type) {
		if (post_type_supports($post_type, 'comments')) {
			remove_post_type_support($post_type, 'comments');
			remove_post_type_support($post_type, 'trackbacks');
		}
	}
}

/**
 * Fecha comentários e pingbacks em qualquer consulta, mesmo os já existentes.
 *
 * @return array
 */
add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);

/**
 * Esconde comentários que já existem no banco, em vez de exibi-los.
 *
 * @param array $comments
 * @return array
 */
add_filter('comments_array', '__return_empty_array', 10, 2);

/**
 * Remove o menu "Comentários" do admin.
 *
 * @return void
 */
add_action('admin_menu', 'aw_remover_menu_comentarios');
function aw_remover_menu_comentarios()
{
	remove_menu_page('edit-comments.php');
}

/**
 * Remove o widget de comentários recentes do dashboard.
 *
 * @return void
 */
add_action('wp_dashboard_setup', 'aw_remover_widget_comentarios');
function aw_remover_widget_comentarios()
{
	remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
}

/**
 * Remove o ícone/link de comentários da barra de admin.
 *
 * @return void
 */
add_action('init', 'aw_remover_admin_bar_comentarios');
function aw_remover_admin_bar_comentarios()
{
	if (is_admin_bar_showing()) {
		remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
	}
}

/**
 * Redireciona quem tentar acessar edit-comments.php direto pela URL.
 *
 * @return void
 */
add_action('admin_init', 'aw_bloquear_pagina_comentarios');
function aw_bloquear_pagina_comentarios()
{
	global $pagenow;

	if ($pagenow === 'edit-comments.php') {
		wp_safe_redirect(admin_url());
		exit;
	}
}

/**
 * Remove a coluna de comentários das listagens de posts e páginas.
 *
 * @param array $columns
 * @return array
 */
add_filter('manage_posts_columns', 'aw_remover_coluna_comentarios');
add_filter('manage_pages_columns', 'aw_remover_coluna_comentarios');
function aw_remover_coluna_comentarios($columns)
{
	unset($columns['comments']);

	return $columns;
}

/**
 * Remove os itens de comentários do menu de "+ Novo" na barra de admin.
 *
 * @return void
 */
add_action('wp_before_admin_bar_render', 'aw_remover_admin_bar_novo_comentario');
function aw_remover_admin_bar_novo_comentario()
{
	global $wp_admin_bar;

	if ($wp_admin_bar) {
		$wp_admin_bar->remove_node('comments');
	}
}
