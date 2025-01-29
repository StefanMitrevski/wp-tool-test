<div class="wrap">
    <h1>Blog Analyzer</h1>

    <form method="post">
        <input type="text" name="keyword" value="<?php echo esc_attr($keyword); ?>" placeholder="Enter word to analyze">
        <input type="submit" value="Analyze Word" class="button button-primary">
    </form>

    <table id="post-analysis-table" class="display">
        <thead>
        <tr>
            <th>Title</th>
            <th>Word Count</th>
            <th>Overall Density</th>
            <th>Keyword Density</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($posts_data as $post): ?>
            <tr>
                <td><?php echo esc_html($post['title']); ?></td>
                <td><?php echo $post['word_count']; ?></td>
                <td><?php echo number_format($post['overall_density'], 2); ?>% (<?php echo esc_html($post['top_word']); ?>)</td>
                <td><?php echo number_format($post['keyword_density'], 2); ?>% (<?php echo esc_html($keyword); ?>)</td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
