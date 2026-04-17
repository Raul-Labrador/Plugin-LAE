<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class LAE_Compliance_Pages {

    public static function create_all_if_not_exist() {
        $pages = array(
            'juego-responsable' => array(
                'title'   => 'Juego responsable',
                'content' => '[lae_responsible_footer]',
            ),
            'identificacion-operador' => array(
                'title'   => 'Identificación del operador',
                'content' => '[lae_operator_info]',
            ),
        );

        foreach ( $pages as $slug => $page_data ) {
            $existing_page = get_page_by_path( $slug );

            if ( ! $existing_page ) {
                wp_insert_post( array(
                    'post_title'   => $page_data['title'],
                    'post_name'    => $slug,
                    'post_content' => $page_data['content'],
                    'post_status'  => 'publish',
                    'post_type'    => 'page',
                ) );
            }
        }
    }
}