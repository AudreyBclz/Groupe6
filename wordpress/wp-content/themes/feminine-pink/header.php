<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Feminine_Pink
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head itemscope itemtype="https://schema.org/WebSite">
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> itemscope itemtype="https://schema.org/WebPage">
<?php wp_body_open(); ?>
<div id="page" class="site">	
    <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content (Press Enter)', 'feminine-pink' ); ?></a>
    <div id="mobilemasthead" class="mobile-site-header">
        <div class="container">
            <div class="mobile-site-branding" itemscope itemtype="https://schema.org/Organization">
                <?php 
                if( function_exists( 'has_custom_logo' ) && has_custom_logo() ){
                    the_custom_logo();
                }
                ?>
                <div class="text-logo">
                    <p class="site-title" itemprop="name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" itemprop="url"><?php bloginfo( 'name' ); ?></a></p>
                    <?php         
                    $description = get_bloginfo( 'description', 'display' );
                    if ( $description || is_customize_preview() ) { ?>
                    <p class="site-description" itemprop="description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
                    <?php } ?> 
                </div>           
            </div><!-- .site-branding -->
            <div class="btn-menu-opener">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
        <div class="mobile-menu">
            <?php get_search_form(); ?>
            <nav id="mobile-site-navigation" class="mobile-main-navigation" role="navigation" itemscope itemtype="https://schema.org/SiteNavigationElement">
               <?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
            </nav><!-- #mobile-site-navigation -->
            <?php if( get_theme_mod( 'elegant_pink_ed_social', '1' ) ) do_action( 'elegant_pink_social' ); ?>
        </div>
    </div>
	<header id="masthead" class="site-header" role="banner" itemscope itemtype="https://schema.org/WPHeader">
            
        <div class="header-t">
            <div class="container">
                <div class="site-branding" itemscope itemtype="https://schema.org/Organization">
                    <?php 
                    if( function_exists( 'has_custom_logo' ) && has_custom_logo() ){
                        the_custom_logo();
                    }
                    if ( is_front_page() && is_home() ) : ?>
                        <h1 class="site-title" itemprop="name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" itemprop="url"><?php bloginfo( 'name' ); ?></a></h1>
                    <?php
                    else : ?>
                        <p class="site-title" itemprop="name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" itemprop="url"><?php bloginfo( 'name' ); ?></a></p>
                    <?php
                    endif;          
                    $description = get_bloginfo( 'description', 'display' );
                    if ( $description || is_customize_preview() ) { ?>
                    <p class="site-description" itemprop="description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
                    <?php } ?>            
                </div><!-- .site-branding -->
            </div><!-- .container -->
        </div>

        <div class="header-b">
            <div class="container">

                <nav id="site-navigation" class="main-navigation" role="navigation" itemscope itemtype="https://schema.org/SiteNavigationElement">
                    <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'feminine-pink' ); ?></button>
                    <?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
                </nav><!-- #site-navigation -->

                <div class="tools">

                    <button class="btn-search">
                        <i class="fa fa-search"></i>
                        <div class="search-form-holder">
                            <?php get_search_form(); ?>
                        </div>
                    </button>
                    
                    <?php 
                        if( get_theme_mod( 'elegant_pink_ed_social' ) ){
                            echo '<div class="seperator"></div>';
                            do_action( 'elegant_pink_social' );
                        } 
                    ?>

                </div>
            </container>
        </div>          
   </header><!-- #masthead -->
    
    <?php 
        if ( is_front_page() ) {
            if( get_theme_mod( 'elegant_pink_ed_slider', '1' ) ) do_action( 'elegant_pink_slider' );
        }    
    ?>
    
    <div class="container">
        <?php if( ! is_404() ) { ?>
            <div id="content" class="site-content">
        <?php } ?>
