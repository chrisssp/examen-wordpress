<footer class="bg-apple-text text-white mt-auto">
    <div class="max-w-4xl mx-auto px-6 py-12">
        <div class="flex flex-col md:flex-row justify-between items-center gap-6">
            <div>
                <p class="text-lg font-semibold"><?php bloginfo('name'); ?></p>
                <p class="text-sm text-gray-400 mt-1"><?php bloginfo('description'); ?></p>
            </div>
            <div class="text-sm text-gray-400">
                &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. Todos los derechos reservados.
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
