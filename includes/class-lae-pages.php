<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class LAE_Compliance_Pages {

    public static function create_all_if_not_exist() {
        $pages = array(
            'juego-responsable' => array(
                'title'   => 'Juego responsable',
                'content' => '[lae_responsible_gaming_page]',
            ),
            'autoexclusion' => array(
                'title'   => 'Autoexclusión',
                'content' => '[lae_autoexclusion_page]',
            ),
        );

        foreach ( $pages as $slug => $page_data ) {
            $existing_page = get_page_by_path( $slug );

            if ( ! $existing_page ) {
                wp_insert_post(
                    array(
                        'post_title'   => $page_data['title'],
                        'post_name'    => $slug,
                        'post_content' => $page_data['content'],
                        'post_status'  => 'publish',
                        'post_type'    => 'page',
                    )
                );
            }
        }
    }
}