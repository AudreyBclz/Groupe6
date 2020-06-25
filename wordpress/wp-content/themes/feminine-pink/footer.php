<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Feminine_Pink
 */

?>

    <?php if( ! is_404() ){ ?>
    	</div><!-- #content -->
    <?php } ?>
    
    	<footer class="site-footer">
			<?php if( is_active_sidebar('footer-one') || is_active_sidebar('footer-two') || is_active_sidebar('footer-three') ){?>
            <div class="row">
				
                <?php if(is_active_sidebar('footer-one')){ ?>
                    <div class="col">
                        <?php dynamic_sidebar('footer-one'); ?>
                    </div>
                <?php }?>
				
				
				<?php if(is_active_sidebar('footer-two')){ ?>
                    <div class="col">
                        <?php dynamic_sidebar('footer-two'); ?>
                    </div>
                <?php }?>				
				
                <?php if(is_active_sidebar('footer-three')){ ?>
                    <div class="col">
                        <?php dynamic_sidebar('footer-three'); ?>
                    </div>
                <?php }?>
				
			</div>
            <?php } 
            
            $copyright_text = get_theme_mod( 'elegant_pink_footer_copyright_text' );
            ?>
            <div class="site-info">

                <span>
                <?php
                    if( $copyright_text ){
                        echo wp_kses_post( $copyright_text );
                    }else{
                        /* translators: %s: Current Year */
                        printf( esc_html__( 'Copyright &copy; %s ', 'feminine-pink' ), date_i18n( esc_html__( 'Y', 'feminine-pink' ) ) ); 
                        echo '<a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html( get_bloginfo( 'name' ) ) . '</a>.</span>';
                    }
                ?>
                </span>

                <span>
                    <?php echo esc_html__( 'Feminine Pink | Developed By', 'feminine-pink' ); ?>
                    <a href="<?php echo esc_url( 'https://rarathemes.com/' ) ?>" rel="nofollow" target="_blank"><?php esc_html_e( 'Rara Theme', 'feminine-pink' ) ?></a>
                </span>

                <span><?php printf( esc_html__( 'Powered by: %s', 'feminine-pink' ), '<a href="'. esc_url( __( 'https://wordpress.org/', 'feminine-pink' ) ) .'" target="_blank" rel="nofollow noopener">WordPress</a>' ); ?>
                </span>

                <?php 
                    if ( function_exists( 'the_privacy_policy_link' ) ) {
                        the_privacy_policy_link( '<span>', '</span>' );
                    }
                ?>
            </div>
		</footer>
        
        <div class="overlay"></div>
        
    </div><!-- .container -->
    
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
