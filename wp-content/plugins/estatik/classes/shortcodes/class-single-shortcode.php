<?php

/**
 * Class Es_Single_Shortcode
 */
class Es_Single_Shortcode extends Es_Shortcode
{
	/**
	 * @return string
	 */
	public function get_shortcode_title() {
		return __( 'Single property', 'es-plugin' );
	}

    /**
     * @inheritdoc
     */
    public function build( $atts = array() ) {
    	$atts = shortcode_atts( array(
    		'id' => get_the_ID(),
	    ), $atts );

        $post = get_post( $atts['id'] );

        if ( $post && $post->post_type == 'properties' ) {
            $query = new WP_Query( array( 'post_type' => 'properties', 'p' => $atts['id'] ) );

            global $es_single_page_instance;

            if ( $es_single_page_instance ) {
                remove_filter( 'the_content', array( $es_single_page_instance, 'the_content' ), 1 );
            }

            ob_start();

            if ( $query->have_posts() ) {
                wp_enqueue_style( 'es-front-single-style' );
                wp_enqueue_script( 'es-front-single-script' );
                wp_localize_script( 'es-front-single-script', 'Estatik', Estatik::register_js_variables() );

                while ( $query->have_posts() ) {
                    $query->the_post();
                    es_load_template( 'content-single.php', 'front', 'es_single_template_path' );
                }
                $query->reset_postdata();

                do_action( 'es_shortcode_after', $this->get_shortcode_name() );
            }

            return ob_get_clean();
        }
    }

    /**
     * @inheritdoc
     */
    public function get_shortcode_name() {
        return 'es_single';
    }
}
