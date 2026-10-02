<?php
/**
 * Faixa CTA de agendamento, no rodapé das páginas.
 *
 * Os textos vêm do grupo ACF "Faixa CTA" da página atual (cta_*), porque o
 * Figma usa uma chamada diferente em cada página. O botão cai para o link de
 * agendamento das Opções do Site quando o campo da página está vazio.
 *
 * @package AlfamaWeb
 */

defined('ABSPATH') || exit;

$cta_pagina  = get_queried_object_id();
$cta_imagem  = aw_field('cta_imagem', $cta_pagina, array());
$cta_eyebrow = aw_field('cta_eyebrow', $cta_pagina, 'agendamento fácil e rápido');
$cta_titulo  = aw_field('cta_titulo', $cta_pagina, 'A Horg está esperando por você!');
$cta_botao   = aw_field('cta_botao', $cta_pagina, array());
?>
<section class="mt-40 mb-0" id="cta">
	<div class="container">
		<div class="holder rounded-t-[25px] bg-[#EDF5FF] 2xl:max-h-86 flex items-end">
			<div class="grid grid-cols-12 gap-8">
				<div class="col-span-10 col-start-2 flex flex-col-reverse lg:flex-row justify-between items-center lg:items-end max-lg:pt-8">
					<img class="bottom-0 w-auto h-auto lg:w-1/2 3xl:w-auto"
						src="<?php echo esc_url($cta_imagem['url'] ?? (IMG_URI . 'Medic.png')); ?>"
						alt="<?php echo esc_attr($cta_imagem['alt'] ?? ''); ?>" loading="lazy">
					<div class="section-title items-center text-center mb-6 md:my-4 3xl:my-auto">
						<div class="eyebrow mb-3 lg:mb-4"><?php echo esc_html($cta_eyebrow); ?></div>
						<h2><?php echo esc_html($cta_titulo); ?></h2>
						<div class="line max-w-[300px]"></div>
						<?php aw_botao($cta_botao, __('Agende sua consulta', 'alfama-web'), 'btn escuro mt-10'); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
