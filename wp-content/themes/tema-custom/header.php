<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.svg" type="image/svg+xml">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['-apple-system', 'BlinkMacSystemFont', 'SF Pro Display', 'Segoe UI', 'Roboto', 'sans-serif'],
                    },
                    colors: {
                        apple: {
                            bg: '#f5f5f7',
                            card: '#ffffff',
                            text: '#1d1d1f',
                            muted: '#86868b',
                            blue: '#0071e3',
                            border: '#d2d2d7',
                        }
                    }
                }
            }
        }
    </script>
    <?php wp_head(); ?>
</head>
<body <?php body_class('bg-apple-bg text-apple-text font-sans antialiased flex flex-col min-h-screen'); ?>>
<?php wp_body_open(); ?>

<header class="sticky top-0 z-50 bg-white/70 backdrop-blur-xl border-b border-apple-border">
    <div class="max-w-4xl mx-auto px-6 py-4 flex items-center justify-between">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="text-xl font-semibold tracking-tight text-apple-text hover:text-apple-blue transition-colors">
            <?php bloginfo('name'); ?>
        </a>
        <nav>
            <?php
            wp_nav_menu([
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => 'flex gap-6 text-sm font-medium',
                'fallback_cb'    => false,
                'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
            ]);
            ?>
        </nav>
    </div>
</header>
