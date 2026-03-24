<?php

add_action('cmb2_admin_init', 'ig_register_post_metabox');

function ig_register_post_metabox()
{
    $cmb = new_cmb2_box(array(
        'id'            => 'ig_post_metabox',
        'title'         => esc_html__('Galeria de imagens', 'ig'),
        'object_types'  => array('post'), // Post type
        // 'show_on_cb' => 'ig_show_if_front_page', // function should return a bool value
        'context'    => 'advanced',
        // 'priority'   => 'high',
        // 'show_names' => true, // Show field names on the left
        // 'cmb_styles' => false, // false to disable the CMB stylesheet
        // 'closed'     => true, // true to keep the metabox closed by default
        // 'classes'    => 'extra-class', // Extra cmb2-wrap classes
        // 'classes_cb' => 'ig_add_some_classes', // Add classes through a callback.

        /*
		 * The following parameter is any additional arguments passed as $callback_args
		 * to add_meta_box, if/when applicable.
		 *
		 * CMB2 does not use these arguments in the add_meta_box callback, however, these args
		 * are parsed for certain special properties, like determining Gutenberg/block-editor
		 * compatibility.
		 *
		 * Examples:
		 *
		 * - Make sure default editor is used as metabox is not compatible with block editor
		 *      [ '__block_editor_compatible_meta_box' => false/true ]
		 *
		 * - Or declare this box exists for backwards compatibility
		 *      [ '__back_compat_meta_box' => false ]
		 *
		 * More: https://wordpress.org/gutenberg/handbook/extensibility/meta-box/
		 */
        // 'mb_callback_args' => array( '__block_editor_compatible_meta_box' => false ),
    ));

    $cmb->add_field(array(
        'name'         => esc_html__('Arquivos', 'ig'),
        'desc'         => esc_html__('Faça o upload ou adicione várias imagens/anexos.', 'ig'),
        'id'           => 'ig_file_list',
        'type'         => 'file_list',
        'preview_size' => array(100, 100), // Default: array( 50, 50 )
    ));
}
