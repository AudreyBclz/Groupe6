<?php
/**
 * Customizer Typography Control
 *
 * Taken from Kirki.
 *
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'Feminine_Pink_Typography_Control' ) ) {
    
    class Feminine_Pink_Typography_Control extends WP_Customize_Control {
    
    	public $tooltip = '';
    	public $js_vars = array();
    	public $output = array();
    	public $option_type = 'theme_mod';
    	public $type = 'typography';
    
    	/**
    	 * Refresh the parameters passed to the JavaScript via JSON.
    	 *
    	 * @access public
    	 * @return void
    	 */
    	public function to_json() {
    		parent::to_json();
    
    		if ( isset( $this->default ) ) {
    			$this->json['default'] = $this->default;
    		} else {
    			$this->json['default'] = $this->setting->default;
    		}
    		$this->json['js_vars'] = $this->js_vars;
    		$this->json['output']  = $this->output;
    		$this->json['value']   = $this->value();
    		$this->json['choices'] = $this->choices;
    		$this->json['link']    = $this->get_link();
    		$this->json['tooltip'] = $this->tooltip;
    		$this->json['id']      = $this->id;
    		$this->json['l10n']    = apply_filters( 'feminine-pink-typography-control/il8n/strings', array(
    			'on'                 => esc_attr__( 'ON', 'feminine-pink' ),
    			'off'                => esc_attr__( 'OFF', 'feminine-pink' ),
    			'all'                => esc_attr__( 'All', 'feminine-pink' ),
    			'cyrillic'           => esc_attr__( 'Cyrillic', 'feminine-pink' ),
    			'cyrillic-ext'       => esc_attr__( 'Cyrillic Extended', 'feminine-pink' ),
    			'devanagari'         => esc_attr__( 'Devanagari', 'feminine-pink' ),
    			'greek'              => esc_attr__( 'Greek', 'feminine-pink' ),
    			'greek-ext'          => esc_attr__( 'Greek Extended', 'feminine-pink' ),
    			'khmer'              => esc_attr__( 'Khmer', 'feminine-pink' ),
    			'latin'              => esc_attr__( 'Latin', 'feminine-pink' ),
    			'latin-ext'          => esc_attr__( 'Latin Extended', 'feminine-pink' ),
    			'vietnamese'         => esc_attr__( 'Vietnamese', 'feminine-pink' ),
    			'hebrew'             => esc_attr__( 'Hebrew', 'feminine-pink' ),
    			'arabic'             => esc_attr__( 'Arabic', 'feminine-pink' ),
    			'bengali'            => esc_attr__( 'Bengali', 'feminine-pink' ),
    			'gujarati'           => esc_attr__( 'Gujarati', 'feminine-pink' ),
    			'tamil'              => esc_attr__( 'Tamil', 'feminine-pink' ),
    			'telugu'             => esc_attr__( 'Telugu', 'feminine-pink' ),
    			'thai'               => esc_attr__( 'Thai', 'feminine-pink' ),
    			'serif'              => _x( 'Serif', 'font style', 'feminine-pink' ),
    			'sans-serif'         => _x( 'Sans Serif', 'font style', 'feminine-pink' ),
    			'monospace'          => _x( 'Monospace', 'font style', 'feminine-pink' ),
    			'font-family'        => esc_attr__( 'Font Family', 'feminine-pink' ),
    			'font-size'          => esc_attr__( 'Font Size', 'feminine-pink' ),
    			'font-weight'        => esc_attr__( 'Font Weight', 'feminine-pink' ),
    			'line-height'        => esc_attr__( 'Line Height', 'feminine-pink' ),
    			'font-style'         => esc_attr__( 'Font Style', 'feminine-pink' ),
    			'letter-spacing'     => esc_attr__( 'Letter Spacing', 'feminine-pink' ),
    			'text-align'         => esc_attr__( 'Text Align', 'feminine-pink' ),
    			'text-transform'     => esc_attr__( 'Text Transform', 'feminine-pink' ),
    			'none'               => esc_attr__( 'None', 'feminine-pink' ),
    			'uppercase'          => esc_attr__( 'Uppercase', 'feminine-pink' ),
    			'lowercase'          => esc_attr__( 'Lowercase', 'feminine-pink' ),
    			'top'                => esc_attr__( 'Top', 'feminine-pink' ),
    			'bottom'             => esc_attr__( 'Bottom', 'feminine-pink' ),
    			'left'               => esc_attr__( 'Left', 'feminine-pink' ),
    			'right'              => esc_attr__( 'Right', 'feminine-pink' ),
    			'center'             => esc_attr__( 'Center', 'feminine-pink' ),
    			'justify'            => esc_attr__( 'Justify', 'feminine-pink' ),
    			'color'              => esc_attr__( 'Color', 'feminine-pink' ),
    			'select-font-family' => esc_attr__( 'Select a font-family', 'feminine-pink' ),
    			'variant'            => esc_attr__( 'Variant', 'feminine-pink' ),
    			'style'              => esc_attr__( 'Style', 'feminine-pink' ),
    			'size'               => esc_attr__( 'Size', 'feminine-pink' ),
    			'height'             => esc_attr__( 'Height', 'feminine-pink' ),
    			'spacing'            => esc_attr__( 'Spacing', 'feminine-pink' ),
    			'ultra-light'        => esc_attr__( 'Ultra-Light 100', 'feminine-pink' ),
    			'ultra-light-italic' => esc_attr__( 'Ultra-Light 100 Italic', 'feminine-pink' ),
    			'light'              => esc_attr__( 'Light 200', 'feminine-pink' ),
    			'light-italic'       => esc_attr__( 'Light 200 Italic', 'feminine-pink' ),
    			'book'               => esc_attr__( 'Book 300', 'feminine-pink' ),
    			'book-italic'        => esc_attr__( 'Book 300 Italic', 'feminine-pink' ),
    			'regular'            => esc_attr__( 'Normal 400', 'feminine-pink' ),
    			'italic'             => esc_attr__( 'Normal 400 Italic', 'feminine-pink' ),
    			'medium'             => esc_attr__( 'Medium 500', 'feminine-pink' ),
    			'medium-italic'      => esc_attr__( 'Medium 500 Italic', 'feminine-pink' ),
    			'semi-bold'          => esc_attr__( 'Semi-Bold 600', 'feminine-pink' ),
    			'semi-bold-italic'   => esc_attr__( 'Semi-Bold 600 Italic', 'feminine-pink' ),
    			'bold'               => esc_attr__( 'Bold 700', 'feminine-pink' ),
    			'bold-italic'        => esc_attr__( 'Bold 700 Italic', 'feminine-pink' ),
    			'extra-bold'         => esc_attr__( 'Extra-Bold 800', 'feminine-pink' ),
    			'extra-bold-italic'  => esc_attr__( 'Extra-Bold 800 Italic', 'feminine-pink' ),
    			'ultra-bold'         => esc_attr__( 'Ultra-Bold 900', 'feminine-pink' ),
    			'ultra-bold-italic'  => esc_attr__( 'Ultra-Bold 900 Italic', 'feminine-pink' ),
    			'invalid-value'      => esc_attr__( 'Invalid Value', 'feminine-pink' ),
    		) );
    
    		$defaults = array( 'font-family'=> false );
    
    		$this->json['default'] = wp_parse_args( $this->json['default'], $defaults );
    	}
    
    	/**
    	 * Enqueue scripts and styles.
    	 *
    	 * @access public
    	 * @return void
    	 */
    	public function enqueue() {
    		wp_enqueue_style( 'feminine-pink-typography', get_stylesheet_directory_uri() . '/inc/custom-controls/typography/typography.css', null );
            /*
    		 * JavaScript
    		 */
            wp_enqueue_script( 'jquery-ui-core' );
    		wp_enqueue_script( 'jquery-ui-tooltip' );
    		wp_enqueue_script( 'jquery-stepper-min-js' );
    		
    		// Selectize
    		wp_enqueue_script( 'selectize', get_stylesheet_directory_uri() . '/inc/js/selectize.js', array( 'jquery' ), false, true );
    
    		// Typography
    		wp_enqueue_script( 'feminine-pink-typography', get_stylesheet_directory_uri() . '/inc/custom-controls/typography/typography.js', array(
    			'jquery',
    			'selectize'
    		), false, true );
    
    		$google_fonts   = Feminine_Pink_Fonts::get_google_fonts();
    		$standard_fonts = Feminine_Pink_Fonts::get_standard_fonts();
    		$all_variants   = Feminine_Pink_Fonts::get_all_variants();
    
    		$standard_fonts_final = array();
    		foreach ( $standard_fonts as $key => $value ) {
    			$standard_fonts_final[] = array(
    				'family'      => $key,
    				'label'       => $value['label'],
    				'is_standard' => true,
    				'variants'    => array(
    					array(
    						'id'    => 'regular',
    						'label' => $all_variants['regular'],
    					),
    					array(
    						'id'    => 'italic',
    						'label' => $all_variants['italic'],
    					),
    					array(
    						'id'    => '700',
    						'label' => $all_variants['700'],
    					),
    					array(
    						'id'    => '700italic',
    						'label' => $all_variants['700italic'],
    					),
    				),
    			);
    		}
    
    		$google_fonts_final = array();
    
    		if ( is_array( $google_fonts ) ) {
    			foreach ( $google_fonts as $family => $args ) {
    				$label    = ( isset( $args['label'] ) ) ? $args['label'] : $family;
    				$variants = ( isset( $args['variants'] ) ) ? $args['variants'] : array( 'regular', '700' );
    
    				$available_variants = array();
    				foreach ( $variants as $variant ) {
    					if ( array_key_exists( $variant, $all_variants ) ) {
    						$available_variants[] = array( 'id' => $variant, 'label' => $all_variants[ $variant ] );
    					}
    				}
    
    				$google_fonts_final[] = array(
    					'family'   => $family,
    					'label'    => $label,
    					'variants' => $available_variants
    				);
    			}
    		}
    
    		$final = array_merge( $standard_fonts_final, $google_fonts_final );
    		wp_localize_script( 'feminine-pink-typography', 'feminine_pink_all_fonts', $final );
    	}
    
    	/**
    	 * An Underscore (JS) template for this control's content (but not its container).
    	 *
    	 * Class variables for this control class are available in the `data` JS object;
    	 * export custom variables by overriding {@see WP_Customize_Control::to_json()}.
    	 *
    	 * I put this in a separate file because PhpStorm didn't like it and it fucked with my formatting.
    	 *
    	 * @see    WP_Customize_Control::print_template()
    	 *
    	 * @access protected
    	 * @return void
    	 */
    	protected function content_template() { ?>
    		<# if ( data.tooltip ) { #>
                <a href="#" class="tooltip hint--left" data-hint="{{ data.tooltip }}"><span class='dashicons dashicons-info'></span></a>
            <# } #>
            
            <label class="customizer-text">
                <# if ( data.label ) { #>
                    <span class="customize-control-title">{{{ data.label }}}</span>
                <# } #>
                <# if ( data.description ) { #>
                    <span class="description customize-control-description">{{{ data.description }}}</span>
                <# } #>
            </label>
            
            <div class="wrapper">
                <# if ( data.default['font-family'] ) { #>
                    <# if ( '' == data.value['font-family'] ) { data.value['font-family'] = data.default['font-family']; } #>
                    <# if ( data.choices['fonts'] ) { data.fonts = data.choices['fonts']; } #>
                    <div class="font-family">
                        <h5>{{ data.l10n['font-family'] }}</h5>
                        <select id="typography-font-family-{{{ data.id }}}" placeholder="{{ data.l10n['select-font-family'] }}"></select>
                    </div>
                    <div class="variant variant-wrapper">
                        <h5>{{ data.l10n['style'] }}</h5>
                        <select class="variant" id="typography-variant-{{{ data.id }}}"></select>
                    </div>
                <# } #>   
                
            </div>
            <?php
    	}
    
    }
}