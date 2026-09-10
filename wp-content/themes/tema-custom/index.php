<?php get_header(); ?>

<main class="max-w-4xl mx-auto px-6 py-12 flex-1 w-full">

    <?php if (have_posts()) : ?>
        <div class="grid gap-8">
            <?php while (have_posts()) : the_post(); ?>
                <article class="bg-white rounded-2xl shadow-sm border border-apple-border p-8 hover:shadow-md transition-shadow">
                    <h2 class="text-2xl font-semibold tracking-tight mb-3">
                        <a href="<?php the_permalink(); ?>" class="text-apple-text hover:text-apple-blue transition-colors">
                            <?php the_title(); ?>
                        </a>
                    </h2>

                    <div class="flex items-center gap-3 text-sm text-apple-muted mb-4">
                        <time datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date(); ?></time>
                        <span>&middot;</span>
                        <span><?php foreach (get_the_category() as $cat) echo esc_html($cat->name) . ' '; ?></span>
                    </div>

                    <?php if (has_post_thumbnail()) : ?>
                        <div class="mb-5 rounded-xl overflow-hidden">
                            <?php the_post_thumbnail('large', ['class' => 'w-full h-auto object-cover']); ?>
                        </div>
                    <?php endif; ?>

                    <div class="text-apple-muted leading-relaxed">
                        <?php the_excerpt(); ?>
                    </div>

                    <a href="<?php the_permalink(); ?>" class="inline-block mt-5 text-apple-blue text-sm font-medium hover:underline">
                        Leer mas &rarr;
                    </a>
                </article>
            <?php endwhile; ?>
        </div>
    <?php else : ?>
        <div class="bg-white rounded-2xl shadow-sm border border-apple-border p-12 text-center">
            <p class="text-apple-muted text-lg">No hay contenido disponible.</p>
        </div>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
