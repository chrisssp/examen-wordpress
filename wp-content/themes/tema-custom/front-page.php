<?php
// Desactivar Table of Contents en la homepage
remove_shortcode('ez-toc-shortcode');
add_filter('ez_toc_apply_before_content', '__return_false');
add_filter('ez_toc_shortcode_output', '__return_empty_string');
add_action('wp_enqueue_scripts', function () {
    if (is_front_page()) {
        wp_dequeue_style('ez-toc-style');
        wp_dequeue_script('ez-toc-script');
    }
}, 99);

// Strip TOC HTML from excerpts on front page
add_filter('the_excerpt', function ($output) {
    if (is_front_page()) {
        $output = preg_replace('/<div[^>]*id="ez-toc[^"]*"[^>]*>.*?<\/div>/is', '', $output);
        $output = preg_replace('/<nav[^>]*class="[^"]*ez-toc[^"]*"[^>]*>.*?<\/nav>/is', '', $output);
    }
    return $output;
});
get_header();
?>

<main class="max-w-4xl mx-auto px-6 py-12 flex-1">

    <!-- Hero Section -->
    <section class="text-center mb-16">
        <h1 class="text-5xl font-bold tracking-tight text-apple-text mb-4">
            <?php echo esc_html(get_bloginfo('name')); ?>
        </h1>
        <p class="text-xl text-apple-muted max-w-2xl mx-auto">
            <?php echo esc_html(get_bloginfo('description')); ?>
        </p>
    </section>

    <!-- Featured Post -->
    <?php
    $featured = new WP_Query(['posts_per_page' => 1, 'post_status' => 'publish']);
    if ($featured->have_posts()) :
        $featured->the_post();
    ?>
    <section class="mb-16">
        <a href="<?php the_permalink(); ?>" class="block bg-white rounded-3xl shadow-sm border border-apple-border overflow-hidden hover:shadow-lg transition-shadow group">
            <?php if (has_post_thumbnail()) : ?>
                <div class="aspect-[21/9] overflow-hidden">
                    <?php the_post_thumbnail('large', ['class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-500']); ?>
                </div>
            <?php endif; ?>
            <div class="p-8">
                <div class="flex items-center gap-3 text-sm text-apple-muted mb-3">
                    <span class="bg-apple-blue text-white text-xs font-medium px-3 py-1 rounded-full">Destacado</span>
                    <time datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date(); ?></time>
                </div>
                <h2 class="text-3xl font-semibold tracking-tight text-apple-text group-hover:text-apple-blue transition-colors mb-3">
                    <?php the_title(); ?>
                </h2>
                <p class="text-apple-muted leading-relaxed">
                    <?php echo wp_trim_words(get_the_excerpt(), 40); ?>
                </p>
            </div>
        </a>
    </section>
    <?php wp_reset_postdata(); endif; ?>

    <!-- Recent Posts Grid -->
    <section>
        <h2 class="text-2xl font-semibold tracking-tight text-apple-text mb-8">Ultimas publicaciones</h2>
        <div class="grid md:grid-cols-2 gap-6">
            <?php
            $posts = new WP_Query(['posts_per_page' => 6, 'post_status' => 'publish', 'orderby' => 'date', 'order' => 'DESC']);
            while ($posts->have_posts()) : $posts->the_post();
            ?>
            <a href="<?php the_permalink(); ?>" class="bg-white rounded-2xl shadow-sm border border-apple-border overflow-hidden hover:shadow-md transition-shadow group">
                <?php if (has_post_thumbnail()) : ?>
                    <div class="aspect-video overflow-hidden">
                        <?php the_post_thumbnail('medium_large', ['class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-500']); ?>
                    </div>
                <?php endif; ?>
                <div class="p-6">
                    <div class="flex items-center gap-2 text-xs text-apple-muted mb-2">
                        <time datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date(); ?></time>
                        <span>&middot;</span>
                        <span><?php foreach (get_the_category() as $cat) echo esc_html($cat->name) . ' '; ?></span>
                    </div>
                    <h3 class="text-lg font-semibold text-apple-text group-hover:text-apple-blue transition-colors mb-2">
                        <?php the_title(); ?>
                    </h3>
                    <p class="text-sm text-apple-muted leading-relaxed">
                        <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                    </p>
                </div>
            </a>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
    </section>

</main>

<?php get_footer(); ?>
