<?php get_header(); ?>

<main class="max-w-4xl mx-auto px-6 py-12 flex-1 w-full">
    <?php while (have_posts()) : the_post(); ?>

    <article>
        <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-flex items-center gap-2 text-sm text-apple-muted hover:text-apple-blue transition-colors mb-8">
            &larr; Volver al inicio
        </a>

        <div class="flex items-center gap-3 text-sm text-apple-muted mb-4">
            <?php foreach (get_the_category() as $cat) : ?>
                <span class="bg-apple-blue text-white text-xs font-medium px-3 py-1 rounded-full">
                    <?php echo esc_html($cat->name); ?>
                </span>
            <?php endforeach; ?>
            <time datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date(); ?></time>
        </div>

        <h1 class="text-4xl md:text-5xl font-bold tracking-tight text-apple-text mb-6 leading-tight">
            <?php the_title(); ?>
        </h1>

        <?php if (has_post_thumbnail()) : ?>
            <div class="rounded-2xl overflow-hidden mb-10 shadow-sm border border-apple-border">
                <?php the_post_thumbnail('large', ['class' => 'w-full h-auto object-cover max-h-96']); ?>
            </div>
        <?php endif; ?>

        <div class="post-content">
            <?php the_content(); ?>
        </div>

        <?php $tags = get_the_tags(); if ($tags) : ?>
            <div class="mt-10 pt-8 border-t border-apple-border">
                <div class="flex flex-wrap gap-2">
                    <?php foreach ($tags as $tag) : ?>
                        <span class="bg-apple-bg text-apple-muted text-xs font-medium px-3 py-1 rounded-full border border-apple-border">
                            #<?php echo esc_html($tag->name); ?>
                        </span>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </article>

    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
