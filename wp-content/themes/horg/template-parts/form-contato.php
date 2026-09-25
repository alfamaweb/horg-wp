<?php
/**
 * Formulário de contato — o único <form> que um projeto precisa copiar.
 *
 * Todos os campos de segurança vêm de AW_Form_Dispatcher::campos_ocultos():
 * nonce, id do formulário, URL de retorno, honeypot e slot do reCAPTCHA.
 *
 * @param array $args {
 *     @type string $titulo   Título acima do formulário.
 *     @type bool   $ajax     Envia por AJAX em vez de POST clássico. Default: true.
 * }
 *
 * @package AlfamaWeb
 */

defined('ABSPATH') || exit;

$args = wp_parse_args($args ?? array(), array(
	'titulo' => __('Fale com a gente', 'alfama-web'),
	'ajax'   => true,
));

AW_Recaptcha::enqueue();

$politica = get_page_by_path('politica-de-privacidade');
$id_base  = 'contato-' . wp_generate_password(4, false, false);
?>
<div class="form-holder !drop-shadow-sombra-2 rounded-[20px] bg-white py-8 md:py-18 xl:py-22 px-6 md:px-24 xl:px-36">
	<?php if ($args['titulo']) : ?>
		<div class="section-title items-center text-center mb-10">
			<h2><?php echo esc_html($args['titulo']); ?></h2>
			<div class="line max-w-[200px]"></div>
		</div>
	<?php endif; ?>

	<form id="aw-form"
		action="<?php echo esc_url(admin_url('admin-post.php')); ?>"
		method="post"
		<?php echo $args['ajax'] ? 'data-aw-form-ajax' : ''; ?>>

		<?php AW_Form_Dispatcher::campos_ocultos('contato'); ?>

		<div class="flex flex-col xl:flex-row gap-8">
			<div class="form-group flex-1">
				<input type="text" id="<?php echo esc_attr($id_base); ?>-nome" name="nome"
					placeholder="<?php esc_attr_e('Seu nome', 'alfama-web'); ?>"
					aria-label="<?php esc_attr_e('nome', 'alfama-web'); ?>"
					autocomplete="name" required>
			</div>
			<div class="form-group flex-1">
				<input type="tel" id="<?php echo esc_attr($id_base); ?>-telefone" name="telefone"
					placeholder="<?php esc_attr_e('Seu telefone', 'alfama-web'); ?>"
					aria-label="<?php esc_attr_e('telefone', 'alfama-web'); ?>"
					autocomplete="tel" inputmode="tel" data-aw-mask="telefone" required>
			</div>
			<div class="form-group flex-1">
				<input type="email" id="<?php echo esc_attr($id_base); ?>-email" name="email"
					placeholder="<?php esc_attr_e('Seu e-mail', 'alfama-web'); ?>"
					aria-label="<?php esc_attr_e('email', 'alfama-web'); ?>"
					autocomplete="email" required>
			</div>
		</div>

		<div class="flex flex-col xl:flex-row gap-8 mt-8">
			<div class="form-group flex-1">
				<textarea id="<?php echo esc_attr($id_base); ?>-mensagem" name="mensagem"
					placeholder="<?php esc_attr_e('Digite sua mensagem', 'alfama-web'); ?>"
					aria-label="<?php esc_attr_e('mensagem', 'alfama-web'); ?>"
					autocomplete="off"></textarea>
			</div>
			<div class="form-group flex-1" data-aw-file-texto="<?php esc_attr_e('Anexar arquivos', 'alfama-web'); ?>">
				<input type="file" id="<?php echo esc_attr($id_base); ?>-anexos" name="anexos"
					aria-label="<?php esc_attr_e('anexo', 'alfama-web'); ?>"
					accept=".pdf,.doc,.docx"
					data-aw-file data-aw-file-placeholder="<?php esc_attr_e('Anexar arquivos', 'alfama-web'); ?>">
			</div>
		</div>

		<div class="form-check mt-6">
			<input type="checkbox" id="<?php echo esc_attr($id_base); ?>-lgpd" name="aceite_lgpd" value="1" required>
			<label for="<?php echo esc_attr($id_base); ?>-lgpd">
				<?php
				if ($politica) {
					printf(
						/* translators: %s: link para a política de privacidade. */
						esc_html__('Li e aceito a %s.', 'alfama-web'),
						sprintf(
							'<a href="%s" target="_blank" rel="noopener">%s</a>',
							esc_url(get_permalink($politica)),
							esc_html__('política de privacidade', 'alfama-web')
						)
					);
				} else {
					esc_html_e('Li e aceito a política de privacidade.', 'alfama-web');
				}
				?>
			</label>
		</div>

		<button type="submit" class="btn escuro mx-auto mt-8" data-aw-form-submit>
			<span data-aw-form-label><?php esc_html_e('Enviar mensagem', 'alfama-web'); ?></span>
			<span class="aw-spinner" hidden aria-hidden="true"></span>
		</button>

		<p class="aw-form-status" role="status" aria-live="polite" hidden></p>
	</form>
</div>
