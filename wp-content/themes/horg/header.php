<?php
/**
 * Cabeçalho do site.
 *
 * DÍVIDA RESOLVIDA (v2): nenhuma biblioteca entra aqui como <link> ou <script>
 * literal — tudo passa por wp_enqueue_* em inc/assets.php, e wp_head() é o
 * único ponto de injeção. Isso põe ordem, dependência e versão sob controle.
 *
 * @package AlfamaWeb
 */

defined('ABSPATH') || exit;

$logo_id  = get_theme_mod('custom_logo');
$logo_url = $logo_id ? wp_get_attachment_image_url($logo_id, 'full') : '';
$logo_alt = $logo_id ? get_post_meta($logo_id, '_wp_attachment_image_alt', true) : '';
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#ffffff">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="aw-skip-link" href="#conteudo"><?php esc_html_e('Pular para o conteúdo', 'alfama-web'); ?></a>

<header class="site-header bg-azul" id="topo">
	<div class="container">
		<div class="flex items-center justify-between gap-6 py-4">

			<a href="<?php echo esc_url(home_url('/')); ?>" class="navbar-brand shrink-0" rel="home">
				<?php if ($logo_url) : ?>
					<img src="<?php echo esc_url($logo_url); ?>"
						alt="<?php echo esc_attr($logo_alt ?: get_bloginfo('name')); ?>"
						class="h-18.75 w-auto" width="200" height="40" fetchpriority="high">
				<?php else : ?>
					<span class="text-lg font-semibold"><?php bloginfo('name'); ?></span>
				<?php endif; ?>
			</a>

			<nav class="hidden lg:flex gap-8" aria-label="<?php esc_attr_e('Menu principal', 'alfama-web'); ?>">
				<?php
				wp_nav_menu(array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'nav-menu flex items-center text-white gap-8',
					'depth'          => 2,
					'fallback_cb'    => false,
				));
				?>
				<a href="" class="btn">Agende sua consulta</a>
			</nav>

			<button type="button" class="menu-toggle lg:hidden" data-aw-menu-toggle
				aria-expanded="false" aria-controls="menu-mobile">
				<span class="sr-only"><?php esc_html_e('Abrir menu', 'alfama-web'); ?></span>
				<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
					<path d="M4 7h16M4 12h16M4 17h16" stroke-linecap="round" />
				</svg>
			</button>
		</div>
	</div>

	<div class="menu-mobile" id="menu-mobile" hidden>
		<div class="container flex items-center justify-between py-4">
			<a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
				<span class="text-lg font-semibold"><?php bloginfo('name'); ?></span>
			</a>
			<button type="button" class="menu-close" data-aw-menu-close>
				<span class="sr-only"><?php esc_html_e('Fechar menu', 'alfama-web'); ?></span>
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
					<path d="M6 6l12 12M18 6L6 18" stroke-linecap="round" />
				</svg>
			</button>
		</div>

		<nav class="container py-6" aria-label="<?php esc_attr_e('Menu principal (mobile)', 'alfama-web'); ?>">
			<?php
			wp_nav_menu(array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'nav-menu-mobile flex flex-col gap-5 text-lg',
				'depth'          => 2,
				'fallback_cb'    => false,
			));
			?>
		</nav>

		<div class="container border-t py-6">
			<?php get_template_part('template-parts/social-links'); ?>
		</div>
	</div>
</header>
