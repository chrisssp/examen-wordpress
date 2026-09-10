<?php get_header(); ?>

<main class="max-w-4xl mx-auto px-6 py-20 flex-1 w-full text-center">
    <div class="mb-8">
        <span class="text-8xl font-bold tracking-tighter text-apple-border">404</span>
    </div>
    <h1 class="text-3xl font-semibold tracking-tight text-apple-text mb-4">
        Pagina no encontrada
    </h1>
    <p class="text-lg text-apple-muted mb-8 max-w-md mx-auto">
        La pagina que buscas no existe o fue movida a otra ubicacion.
    </p>
    <a href="<?php echo esc_url(home_url('/')); ?>"
       class="inline-block bg-apple-blue text-white font-medium px-6 py-3 rounded-full hover:opacity-90 transition-opacity">
        Volver al inicio
    </a>
</main>

<?php get_footer(); ?>
