<?php
add_action('rest_api_init', function () {
    register_rest_route('analyzer/v1', '/data/', array(
        'methods' => 'GET',
        'callback' => 'analyzer_get_data',
        'args' => array(
            'keyword' => array(
                'required' => false,
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
            ),
        ),
        //'permission_callback' => 'analyzer_permission_check',
        'permission_callback' => '__return_true',
    ));
});

function analyzer_get_data(WP_REST_Request $request) {
    $keyword = $request->get_param('keyword');

    $posts = get_posts(array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'numberposts' => -1,
    ));

    $data = array();

    foreach ($posts as $post) {
        $content = strip_tags($post->post_content);
        $word_count = str_word_count($content);
        $words = str_word_count(strtolower($content), 1);
        $word_frequency = array_count_values($words);
        arsort($word_frequency);
        $top_word = key($word_frequency);
        $overall_density = ($word_frequency[$top_word] / max($word_count, 1)) * 100;

        $post_data = array(
            'title' => $post->post_title,
            'word_count' => $word_count,
            'top_word' => $top_word,
            'overall_density' => number_format($overall_density, 2),
        );

        if ($keyword) {
            $keyword_count = $word_frequency[strtolower($keyword)] ?? 0;
            $keyword_density = ($keyword_count / max($word_count, 1)) * 100;
            $post_data['keyword'] = $keyword;
            $post_data['keyword_density'] = number_format($keyword_density, 2);
        }
        $data[] = $post_data;
    }

    return rest_ensure_response($data);
}

function analyzer_permission_check(WP_REST_Request $request) {
    return current_user_can('edit_posts');
}
