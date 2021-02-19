<?php

use \Elementor\Plugin;

/**
 * Class Es_Elementor_Init.
 */
class Es_Elementor_Init {

    /**
     * Initialize estatik elementor integration.
     *
     * @return void
     */
    public static function init() {
        add_action( 'elementor/widgets/widgets_registered', array( 'Es_Elementor_Init', 'register_widgets' ) );
        add_action( 'elementor/elements/categories_registered', array( 'Es_Elementor_Init', 'register_category' ) );
        add_filter( 'elementor/widgets/black_list', array( 'Es_Elementor_Init', 'widgets_black_list' ) );
        add_action( 'elementor/documents/register', array( 'Es_Elementor_Init', 'register_document_type' ) );
//        add_action( 'es_before_save_property_data', array( 'Es_Elementor_Init', 'save_post_content' ) );
    }

//    /**
//     * @param $data array
//     * @param $property Es_Property
//     */
//    public function save_post_content( $data, $property ) {
//        $editor_mode = get_post_meta( $property->getID(), '_elementor_edit_mode', true );
//        $alt_desc = $property->alternative_description;
//
//        if ( 'builder' != $editor_mode && empty( $alt_desc ) ) {
//
//        }
//    }

    /**
     * @param $manager Elementor\Core\Documents_Manager
     */
    public static function register_document_type( $manager ) {

        if ( class_exists( 'ElementorPro\Modules\ThemeBuilder\Documents\Single_Base' ) ) {
            require_once ES_PLUGIN_PATH . '/classes/class-elementor-property-document.php';
        }

        if ( class_exists( 'Es_Elementor_Property_Document' ) ) {
            $manager->register_document_type( 'properties', 'Es_Elementor_Property_Document' );
        }
    }

    /**
     * Disable default estatik widgets for elementor.
     *
     * @param $list
     * @return array
     */
    public static function widgets_black_list( $list ) {
        $list[] = 'Es_Property_Slideshow_Widget';
        $list[] = 'Es_Request_Widget';
        $list[] = 'Es_Search_Widget';

        return $list;
    }

    /**
     * Register elementor widgets.
     *
     * @return void
     * @throws Exception
     */
    public static function register_widgets() {
        if ( class_exists( 'Elementor\Widget_Base' ) ) {
            require_once trailingslashit( ES_PLUGIN_PATH . '/admin/classes/widgets/elementor/' ) . 'class-elementor-base.php';
            require_once trailingslashit( ES_PLUGIN_PATH . '/admin/classes/widgets/elementor/' ) . 'class-elementor-slideshow-widget.php';
            require_once trailingslashit( ES_PLUGIN_PATH . '/admin/classes/widgets/elementor/' ) . 'class-elementor-request-widget.php';
            require_once trailingslashit( ES_PLUGIN_PATH . '/admin/classes/widgets/elementor/' ) . 'class-elementor-search-widget.php';
            require_once trailingslashit( ES_PLUGIN_PATH . '/admin/classes/widgets/elementor/' ) . 'class-elementor-listings-widget.php';

            Plugin::instance()->widgets_manager->register_widget_type( new Elementor_Es_Slideshow_Widget() );
            Plugin::instance()->widgets_manager->register_widget_type( new Elementor_Es_Request_Widget() );
            Plugin::instance()->widgets_manager->register_widget_type( new Elementor_Es_Search_Widget() );
            Plugin::instance()->widgets_manager->register_widget_type( new Elementor_Es_Listings_Widget() );
        }
    }

    /**
     * Register new Estatik category.
     *
     * @param $elements_manager \Elementor\Elements_Manager
     */
    public static function register_category( $elements_manager ) {
        $elements_manager->add_category(
            'estatik-category',
            array(
                'title' => _x( 'Estatik', 'Elementor widgets category name', 'es' ),
            )
        );
    }
}

Es_Elementor_Init::init();
