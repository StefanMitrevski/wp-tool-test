<?php
function ba_display_page() {
    $keyword = isset($_POST['keyword']) ? sanitize_text_field($_POST['keyword']) : '';
    $posts_data = ba_analyze_posts($keyword);

    include plugin_dir_path(__FILE__) . '../includes/analyzer.php';
}

function ba_analyze_posts($keyword)
{
    $posts = get_posts(array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'numberposts' => -1
    ));

    $posts_data = array();

    foreach ($posts as $post) {
        $content = strip_tags($post->post_content);
        $word_count = str_word_count($content);
        $words = str_word_count(strtolower($content), 1);
        $word_frequency = array_count_values($words);
        arsort($word_frequency);
        $top_word = key($word_frequency);
        $overall_density = ($word_frequency[$top_word] / $word_count) * 100;

        $keyword_count = $word_frequency[strtolower($keyword)] ?? 0;
        $keyword_density = ($keyword_count / $word_count) * 100;

        $posts_data[] = array(
            'title' => $post->post_title,
            'word_count' => $word_count,
            'overall_density' => $overall_density,
            'top_word' => $top_word,
            'keyword_density' => $keyword_density
        );
    }

    return $posts_data;
}