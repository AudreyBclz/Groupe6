<?php
/**
 * Theme functions and definitions
 *
 * @package Feminine_Pink
 */

/**
 * After setup theme hook
 */
function feminine_pink_theme_setup(){
    /*
     * Make chile theme available for translation.
     * Translations can be filed in the /languages/ directory.
     */
    load_child_theme_textdomain( 'feminine-pink', get_stylesheet_directory() . '/languages' );

}
add_action( 'after_setup_theme', 'feminine_pink_theme_setup' );

/**
 * Load assets.
 *
 */
function feminine_pink_enqueue_styles() {
    $my_theme = wp_get_theme();
    $version = $my_theme['Version'];

    wp_enqueue_style( 'feminine-pink-google-fonts', feminine_pink_fonts_url(), array(), null );
    wp_enqueue_style( 'elegant-pink-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'feminine-pink-style', get_stylesheet_directory_uri() . '/style.css', array( 'elegant-pink-style' ), $version );

    wp_enqueue_script( 'feminine-pink-custom-js', get_stylesheet_directory_uri() . '/js/custom.js', array('jquery'), $version, true );

}
add_action( 'wp_enqueue_scripts', 'feminine_pink_enqueue_styles' );

/**
 * Add style for site title
 */
function feminine_pink_add_custom_style(){
    $site_title_font      = get_theme_mod( 'site_title_font', array( 'font-family'=>'Dancing Script', 'variant'=>'700' ) );
    $site_title_fonts     = feminine_pink_get_fonts( $site_title_font['font-family'], $site_title_font['variant'] );
    $site_title_font_size = get_theme_mod( 'site_title_font_size', 50 );

    ?>
    <style>
      .site-header .site-branding .site-title{
        font-size   : <?php echo absint( $site_title_font_size ); ?>px;
        font-family : <?php echo wp_kses_post( $site_title_fonts['font'] ); ?>;
        font-weight : <?php echo esc_html( $site_title_fonts['weight'] ); ?>;
        font-style  : <?php echo esc_html( $site_title_fonts['style'] ); ?>;
        }
    </style>
    <?php
}
add_action( 'wp_head', 'feminine_pink_add_custom_style' );


/**
 * Typography Functions
 */
require get_stylesheet_directory() . '/inc/typography.php';

/**
 * Remove action from parent
*/
function school_zone_remove_parent_action(){
    remove_action( 'customize_register', 'elegant_pink_customizer_theme_info' );
    remove_action( 'pre_get_posts', 'elegant_pink_exclude_posts_for_homepage' );
}
add_action( 'init', 'school_zone_remove_parent_action' );

/**
 * Remove slider post from homepage posts
 */
function feminine_pink_exclude_posts_for_homepage( $query ) {
    $show_on_front   = get_option( 'show_on_front' );
    $ed_slider       = get_theme_mod( 'elegant_pink_ed_slider', '1' );
    $slider_type     = get_theme_mod( 'elegant_pink_slider_type', 'latest-post' );
    $number_of_posts = get_theme_mod( 'feminine_pink_slider_number', 3 );
    $slider_category = get_theme_mod( 'elegant_pink_slider_cat', '' );
    $slider_post1    = get_theme_mod( 'elegant_pink_slider_post1' );
    $slider_post2    = get_theme_mod( 'elegant_pink_slider_post2' );
    $slider_post3    = get_theme_mod( 'elegant_pink_slider_post3' );

    if ( ! is_admin() && $query->is_home() && $query->is_main_query() && $ed_slider && 'posts' == $show_on_front ) {

        if( 'latest-post' == $slider_type ){
            $args = array(
               'post_type'           => 'post',
               'post_status'         => 'publish',
               'posts_per_page'      => $number_of_posts,
               'ignore_sticky_posts' => true
            );
            $latest_post = get_posts( $args );
            $excludes = array();

            foreach( $latest_post as $latest ){
               array_push( $excludes, $latest->ID );
            }
            
            $query->set( 'post__not_in', $excludes );

        }elseif( 'category' == $slider_type ){
            $query->set( 'category__not_in', $slider_category );
        }elseif( 'post' == $slider_type ){
            $sliders = array( $slider_post1, $slider_post2, $slider_post3 );        
            $sliders = array_diff( array_unique( $sliders ), array('') );

            if( ! empty( $sliders ) ){
                $query->set( 'post__not_in', $sliders );
            }
        }
    }
}
add_action( 'pre_get_posts', 'feminine_pink_exclude_posts_for_homepage' );

function feminine_pink_customizer_theme_info( $wp_customize ) {
    
    $wp_customize->add_section( 'theme_info' , array(
        'title'       => __( 'Information Links' , 'feminine-pink' ),
        'priority'    => 6,
        ));

    $wp_customize->add_setting('theme_info_theme',array(
        'default' => '',
        'sanitize_callback' => 'wp_kses_post',
        ));
    
    $theme_info = '';
    $theme_info .= '<h3 class="sticky_title">' . __( 'Need help?', 'feminine-pink' ) . '</h3>';
    $theme_info .= '<span class="sticky_info_row"><label class="row-element">' . __( 'View demo', 'feminine-pink' ) . ': </label><a href="' . esc_url( 'https://rarathemes.com/previews/?theme=feminine-pink/' ) . '" target="_blank" rel="nofollow noopener">' . __( 'here', 'feminine-pink' ) . '</a></span><br />';
    $theme_info .= '<span class="sticky_info_row"><label class="row-element">' . __( 'View documentation', 'feminine-pink' ) . ': </label><a href="' . esc_url( 'https://docs.rarathemes.com/docs/feminine-pink/' ) . '" target="_blank" rel="nofollow noopener">' . __( 'here', 'feminine-pink' ) . '</a></span><br />';
    $theme_info .= '<span class="sticky_info_row"><label class="row-element">' . __( 'Theme info', 'feminine-pink' ) . ': </label><a href="' . esc_url( 'https://rarathemes.com/wordpress-themes/feminine-pink/' ) . '" target="_blank" rel="nofollow noopener">' . __( 'here', 'feminine-pink' ) . '</a></span><br />';
    $theme_info .= '<span class="sticky_info_row"><label class="row-element">' . __( 'Support ticket', 'feminine-pink' ) . ': </label><a href="' . esc_url( 'https://rarathemes.com/support-ticket/' ) . '" target="_blank" rel="nofollow noopener">' . __( 'here', 'feminine-pink' ) . '</a></span><br />';
    $theme_info .= '<span class="sticky_info_row"><label class="more-detail row-element">' . __( 'More WordPress Themes', 'feminine-pink' ) . ': </label><a href="' . esc_url( 'https://rarathemes.com/wordpress-themes/' ) . '" target="_blank" rel="nofollow noopener">' . __( 'here', 'feminine-pink' ) . '</a></span><br />';


    $wp_customize->add_control( new Elegant_Pink_Theme_Info( $wp_customize ,'theme_info_theme',array(
        'label' => __( 'About Feminine Pink' , 'feminine-pink' ),
        'section' => 'theme_info',
        'description' => $theme_info
        )));

    $wp_customize->add_setting('theme_info_more_theme',array(
        'default' => '',
        'sanitize_callback' => 'wp_kses_post',
        ));

}
add_action( 'customize_register', 'feminine_pink_customizer_theme_info' );

/**
 * Disable customizer fields from parent
 */
add_action( 'customize_register', 'feminine_pink_customize_register',50 );

function feminine_pink_customize_register( $wp_customize ){

    // Load our custom control.
    require_once get_stylesheet_directory() . '/inc/custom-controls/slider/class-slider-control.php';
    require_once get_stylesheet_directory() . '/inc/custom-controls/select/class-select-control.php';
    require_once get_stylesheet_directory() . '/inc/custom-controls/typography/class-fonts.php';
    require_once get_stylesheet_directory() . '/inc/custom-controls/typography/class-typography-control.php';
            
    // Register the control type.
    $wp_customize->register_control_type( 'Feminine_Pink_Select_Control' );
    $wp_customize->register_control_type( 'Feminine_Pink_Slider_Control' );
    $wp_customize->register_control_type( 'Feminine_Pink_Typography_Control' ); 

    // Change priority of parent theme control
    $wp_customize->get_setting( 'elegant_pink_ed_slider' )->default     = '1';    
    $wp_customize->get_control( 'elegant_pink_slider_cat' )->priority   = '100';    
    $wp_customize->get_control( 'elegant_pink_slider_post1' )->priority = '101';    
    $wp_customize->get_control( 'elegant_pink_slider_post2' )->priority = '102';    
    $wp_customize->get_control( 'elegant_pink_slider_post3' )->priority = '103';    

    // Slider control
    $wp_customize->remove_setting( 'elegant_pink_slider_type');
    $wp_customize->remove_control( 'elegant_pink_slider_type');

    /** Site Title Font */
    $wp_customize->add_setting( 
        'site_title_font', 
        array(
            'default' => array(                                         
                'font-family' => 'Dancing Script',
                'variant'     => '700',
            ),
            'sanitize_callback' => array( 'Feminine_Pink_Fonts', 'sanitize_typography' )
        ) 
    );

    $wp_customize->add_control( 
        new Feminine_Pink_Typography_Control( 
            $wp_customize, 
            'site_title_font', 
            array(
                'label'       => __( 'Site Title Font', 'feminine-pink' ),
                'description' => __( 'Site title and tagline font.', 'feminine-pink' ),
                'section'     => 'title_tagline',
                'priority'    => 60, 
            ) 
        ) 
    );

    /** Site Title Font Size*/
    $wp_customize->add_setting( 
        'site_title_font_size', 
        array(
            'default'           => 50,
            'sanitize_callback' => 'elegant_pink_sanitize_number_absint'
        ) 
    );
    
    $wp_customize->add_control(
        new Feminine_Pink_Slider_Control( 
            $wp_customize,
            'site_title_font_size',
            array(
                'section'     => 'title_tagline',
                'label'       => __( 'Site Title Font Size', 'feminine-pink' ),
                'description' => __( 'Change the font size of your site title.', 'feminine-pink' ),
                'priority'    => 65,
                'choices'     => array(
                    'min'   => 10,
                    'max'   => 100,
                    'step'  => 1,
                )                 
            )
        )
    );

    /** Slider Type */
    $wp_customize->add_setting(
        'elegant_pink_slider_type',
        array(
            'default' => 'latest-post',
            'sanitize_callback' => 'elegant_pink_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
         new Feminine_Pink_Select_Control( 
            $wp_customize,
            'elegant_pink_slider_type',
            array(
                'label' => __( 'Choose Slider Type', 'feminine-pink' ),
                'section' => 'elegant_pink_slider_settings',
                'choices' => array(
                    'category'    => __( 'Category Posts', 'feminine-pink' ),
                    'post'        => __( 'Single Posts', 'feminine-pink' ),
                    'latest-post' => __( 'Latest Posts', 'feminine-pink' ),
                )
            )
        )
    );

    /** Number of slides */
    $wp_customize->add_setting(
        'feminine_pink_slider_number',
        array(
            'default' => 3,
            'sanitize_callback' => 'elegant_pink_sanitize_number_absint',
        )
    );
    
    $wp_customize->add_control(
        new Feminine_Pink_Slider_Control( 
            $wp_customize,
            'feminine_pink_slider_number',
            array(
                'label' => __( 'Choose Number of slides', 'feminine-pink' ),
                'section' => 'elegant_pink_slider_settings',
                'choices' => array(
                    'min'  => 1,
                    'max'  => 10,
                    'step' => 1
                ),
                'active_callback' => 'feminine_pink_slider_active_callback'
            )
        )
    );
}

/**
 * Active Callback
 * 
 */ 
 function feminine_pink_slider_active_callback( $control ) {
    $radio_setting = $control->manager->get_setting('elegant_pink_slider_type')->value();
    $control_id = $control->id;
     
    if ( $control_id == 'elegant_pink_slider_cat'  && $radio_setting == 'category' ) return true;
    if ( $control_id == 'feminine_pink_slider_number' && $radio_setting == 'latest-post' ) return true;
     
    return false;
}

/**
 * Callback function for Home Page Slider 
 */
function feminine_pink_slider_callback(){
    $slider_caption  = get_theme_mod( 'elegant_pink_slider_caption', '1' );
    $slider_readmore = get_theme_mod( 'elegant_pink_slider_readmore', __( 'Read More', 'feminine-pink' ) );
    $slider_type     = get_theme_mod( 'elegant_pink_slider_type', 'latest-post' );
    $slider_cat      = get_theme_mod( 'elegant_pink_slider_cat' );
    $slider_post1    = get_theme_mod( 'elegant_pink_slider_post1' );
    $slider_post2    = get_theme_mod( 'elegant_pink_slider_post2' );
    $slider_post3    = get_theme_mod( 'elegant_pink_slider_post3' );
    $slider_word     = get_theme_mod( 'elegant_pink_slider_words', 13 );
    
    $sliders       = array( $slider_post1, $slider_post2, $slider_post3 );        
    $sliders       = array_diff( array_unique( $sliders ), array('') );
    $slider_number = get_theme_mod( 'feminine_pink_slider_number', 3 );

    $arg = array(); // initialize an empty array

    if( ( $slider_type == 'category' ) && $slider_cat ){
        $arg = array(
            'post_type'     => 'post',
            'post_status'   => 'publish',
            'posts_per_page'=> -1,
            'cat'           => $slider_cat,
        );
    } elseif( ( $slider_type == 'post' ) && $sliders ){
        $arg = array(
            'post_type'   => 'post',
            'post_status' => 'publish',
            'post__in'    => $sliders,
            'orderby'     => 'post__in'
        );
    } elseif( $slider_type == 'latest-post' ) {
        $arg = array(
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'posts_per_page' => $slider_number,
        );
    }

    if( ! empty( $arg ) ){
 
        $qry = new WP_Query( $arg );

        if( $qry->have_posts() ){ ?>
            <div class="slideshow">
                <div id="imageGallery" class="owl-carousel owl-theme">
                <?php
                while( $qry->have_posts() ){
                    $qry->the_post();                
                    ?>
                    <div>
                        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'elegant-pink-slider', array( 'itemprop' => 'image' ) ); ?></a>
                        <?php if( $slider_caption ){ ?>
                        <div class="banner-text">
                            <div class="text">
                                <?php elegant_pink_category(); ?>                           
                                <strong class="title"><?php the_title() ?></strong>
                                <?php 
                                    if( has_excerpt() ){
                                        the_excerpt();  
                                    }else{ 
                                        echo wpautop( wp_kses_post( wp_trim_words( strip_shortcodes( get_the_content() ), $slider_word ) ) );
                                    }
                                ?>
                                <a href="<?php the_permalink();?>" class="btn-readmore"><?php echo esc_html( $slider_readmore ); ?></a>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    <?php                
                }
                wp_reset_postdata();
                ?>
                </div>
            </div>
        <?php
        }
    }
}
add_action( 'elegant_pink_slider', 'feminine_pink_slider_callback' );