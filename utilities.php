<?php

/**
 * ig_debug
 *
 * @param  mixed $debug
 * @return mixed
 */
function ig_debug($debug)
{
    echo '<pre>';
    var_dump($debug);
    echo '</pre>';
}

/**
 * ig_version
 *
 * @return string
 */
function ig_version()
{
    // $version = '1.0.1';
    $version = rand(0, 9999);

    // generate random version
    return $version;
}

/**
 * ig_format_money
 *
 * @param  mixed $number
 * @return string
 */
function ig_format_money($number, $decimal = 0)
{
    if (!is_numeric($number)) {
        $number = str_replace('.', '', $number);
        $number = str_replace(',', '.', $number);
    }
    $number = floatval($number);
    return number_format($number, $decimal, ',', '.');
}

/**
 * ig_format_number
 *
 * @param  string $number
 * @return float
 */
function ig_format_number($number)
{
    $number = str_replace('.', '', $number);
    $number = str_replace(',', '.', $number);
    $number = floatval($number);
    return $number;
}

/**
 * ig_slugify
 *
 * @param  string $text
 * @param  string $divider
 * @return string
 */
function ig_slugify($text, string $divider = '-')
{
    // Mapeamento de caracteres acentuados comuns em português
    $acentos = array(
        'à',
        'á',
        'â',
        'ã',
        'ä',
        'å',
        'ç',
        'è',
        'é',
        'ê',
        'ë',
        'ì',
        'í',
        'î',
        'ï',
        'ñ',
        'ò',
        'ó',
        'ô',
        'õ',
        'ö',
        'ù',
        'ü',
        'ú',
        'ÿ',
        'À',
        'Á',
        'Â',
        'Ã',
        'Ä',
        'Å',
        'Ç',
        'È',
        'É',
        'Ê',
        'Ë',
        'Ì',
        'Í',
        'Î',
        'Ï',
        'Ñ',
        'Ò',
        'Ó',
        'Ô',
        'Õ',
        'Ö',
        'Ù',
        'Ü',
        'Ú',
        'Ÿ',
        'ä',
        'ö',
        'ü',
        'ß',
        'Ä',
        'Ö',
        'Ü'
    );

    $semAcentos = array(
        'a',
        'a',
        'a',
        'a',
        'a',
        'a',
        'c',
        'e',
        'e',
        'e',
        'e',
        'i',
        'i',
        'i',
        'i',
        'n',
        'o',
        'o',
        'o',
        'o',
        'o',
        'u',
        'u',
        'u',
        'y',
        'A',
        'A',
        'A',
        'A',
        'A',
        'A',
        'C',
        'E',
        'E',
        'E',
        'E',
        'I',
        'I',
        'I',
        'I',
        'N',
        'O',
        'O',
        'O',
        'O',
        'O',
        'U',
        'U',
        'U',
        'Y',
        'ae',
        'oe',
        'ue',
        'ss',
        'Ae',
        'Oe',
        'Ue'
    );

    $text = strtolower($text); // Converte para minúsculas
    $text = str_replace($acentos, $semAcentos, $text); // Remove acentos

    // Substitui caracteres não alfanuméricos e espaços por hífen
    $text = preg_replace('~[^\\pL\\pN]+~u', $divider, $text);
    $text = trim($text, $divider); // Remove hífens extras no início/fim
    $text = preg_replace('~-+~', $divider, $text); // Remove hífens duplicados

    if (empty($text)) {
        return 'n-a';
    }
    return $text;
}

add_action('wp_ajax_nopriv_ig_get_gallery', 'ig_get_gallery');
add_action('wp_ajax_ig_get_gallery', 'ig_get_gallery');

function ig_get_gallery()
{
    $post_id = isset($_POST['post_id']) ? sanitize_text_field($_POST['post_id']) : null;
    if (!$post_id) {
        wp_send_json_error(array('msg' => __('ID do post ausente', 'ig')), 200);
    }
    $file_list = [];
    $ig_file_list = get_post_meta($post_id, 'ig_file_list', true);
    if ($ig_file_list) {
        foreach ($ig_file_list as $id => $file) {
            $post_data = get_post($id);
            $file_obj = new stdClass();
            $file_obj->id = $id;
            $file_obj->file = $file;
            $file_obj->title = $post_data->post_title;
            $file_obj->caption = $post_data->post_excerpt;
            $file_obj->description = $post_data->post_content;
            $file_obj->alt_text = get_post_meta($id, '_wp_attachment_image_alt', true);
            $file_list[] = $file_obj;
        }
    }
    $response = array(
        'file_list'                         => $file_list,
    );
    wp_send_json_success($response);
}
