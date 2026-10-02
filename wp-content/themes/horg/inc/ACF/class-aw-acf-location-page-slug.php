<?php
/**
 * Regra de localização do ACF: "Página (slug)".
 *
 * As regras nativas "Página == ID" quebram entre ambientes (o ID da página
 * Sobre no local não é o mesmo do dev2/produção). O slug viaja junto com o
 * conteúdo, então os grupos do acf-json/ passam a valer em qualquer ambiente.
 *
 * @package AlfamaWeb
 */

defined('ABSPATH') || exit;

class AW_ACF_Location_Page_Slug extends ACF_Location
{
	/**
	 * @return void
	 */
	public function initialize()
	{
		$this->name        = 'aw_page_slug';
		$this->label       = __('Página (slug)', 'alfama-web');
		$this->category    = 'page';
		$this->object_type = 'post';
	}

	/**
	 * @param array $rule
	 * @param array $screen
	 * @param array $field_group
	 * @return bool
	 */
	public function match($rule, $screen, $field_group)
	{
		$post_id = $screen['post_id'] ?? 0;

		if (!$post_id) {
			return false;
		}

		$post = get_post($post_id);

		if (!$post || 'page' !== $post->post_type) {
			return false;
		}

		return $this->compare_to_rule($post->post_name, $rule);
	}

	/**
	 * @param array $rule
	 * @return array
	 */
	public function get_values($rule)
	{
		$valores = array();

		foreach (get_pages(array('post_status' => array('publish', 'draft', 'private'))) as $pagina) {
			$valores[$pagina->post_name] = $pagina->post_title . ' (' . $pagina->post_name . ')';
		}

		return $valores;
	}
}
