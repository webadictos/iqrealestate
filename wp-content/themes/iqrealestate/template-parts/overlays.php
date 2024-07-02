<div class="offcanvas offcanvas-top hamburger-menu" tabindex="-1" id="menuoffcanvas" aria-labelledby="menuoffcanvasLabel">
    <div class="offcanvas-header">
        <button type="button" class="btn-close close-hamburger" data-bs-dismiss="offcanvas" aria-label="Close">

            <svg class="icon-close" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M20 5.61143L18.3886 4L12 10.3886L5.61143 4L4 5.61143L10.3886 12L4 18.3886L5.61143 20L12 13.6114L18.3886 20L20 18.3886L13.6114 12L20 5.61143Z" />
            </svg>

        </button>

        <?php
        $logo = wa_theme()->setting('general', 'logo_dark') ?? '';

        if ($logo !== "") :
        ?>
            <img class="hamburguer-menu__logo" src="<?php echo $logo; ?>" width="139" height="33" alt="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" loading="lazy" fetchpriority="low">



        <?php endif; ?>
    </div>
    <div class="offcanvas-body offcanvas-menu">

        <nav class="navbar h-100">

            <?php
            if (has_nav_menu('hamburger-menu')) :

                // Loading WordPress Custom Menu (theme_location).
                wp_nav_menu(
                    array(
                        'menu_class'     => 'navbar-nav',
                        'container'      => 'div',
                        'container_class' => 'menu-hamburger__main-items collapse show navbar-collapse justify-content-start',
                        'fallback_cb'    => 'WP_Bootstrap_Navwalker::fallback',
                        'walker'          => new WP_Bootstrap_Navwalker(),
                        'theme_location' => 'hamburger-menu',
                    )
                );
            // wp_nav_menu(array(
            //     'theme_location' => 'hamburguer-menu',
            //     'container'       => 'div',
            //     'container_id'    => 'main-menu-left-nav',
            //     'container_class' => 'menu-hamburguer__main-items collapse show navbar-collapse justify-content-start mb-auto',
            //     'menu_class'      => 'navbar-nav',
            //     'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
            //     'walker'          => new WP_Bootstrap4_Navwalker_Footer()
            // ));
            endif;
            ?>

            <div class="navbar-text w-100 hamburger-menu__social">
                <?php
                if (function_exists('wa_show_social_profiles')) {
                    wa_show_social_profiles(array('exclude' => array('email')));
                }
                ?>


                <?php
                if (has_nav_menu('privacy-menu')) : // See function register_nav_menus() in functions.php

                    wp_nav_menu(
                        array(
                            'container'       => 'nav',
                            'container_class' => 'hamburger__menu-privacy',
                            //'fallback_cb'     => 'WP_Bootstrap4_Navwalker_Footer::fallback',
                            'walker'          => new WP_Bootstrap4_Navwalker_Footer(),
                            'theme_location'  => 'privacy-menu',
                            'items_wrap'      => '<ul class="menu nav">%3$s</ul>',
                        )
                    );
                endif;
                ?>
            </div>


        </nav>


    </div>
</div>

<div class="overlay-background"></div>