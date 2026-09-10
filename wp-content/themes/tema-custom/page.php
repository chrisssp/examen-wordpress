<?php get_header(); ?>

<main class="max-w-4xl mx-auto px-6 py-12 flex-1 w-full">
    <?php while (have_posts()) : the_post(); ?>

    <article>
        <h1 class="text-4xl font-bold tracking-tight text-apple-text mb-6 leading-tight">
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
    </article>

    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
