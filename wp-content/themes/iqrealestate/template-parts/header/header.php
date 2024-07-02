<?php
$logo = wa_theme()->setting('general', 'logo') ?? '';
$logo_dark = wa_theme()->setting('general', 'logo_dark') ?? '';
$logo_navbar = wa_theme()->setting('general', 'logo_navbar') ?? '';



// if (is_home() || is_front_page()) {
//     $logo = $logo_dark !== "" ? $logo_dark : $logo;
// }

?>
<header id="masthead" class="masthead  <?php echo (is_home() || is_front_page()) ? 'header-home' : ''; ?>">


    <?php
    do_action('wa_inner_header_top');
    ?>

    <div class="container-fluid container-xl">
        <div class="header-top-container">




            <div class="header__logo">
                <a class="navbar-brand" id="logo-edition" href="<?php echo esc_url(home_url()); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home">

                    <?php
                    if (!empty($logo)) :
                    ?>
                        <img class="main-logo" src="<?php echo esc_url($logo); ?>" alt="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" width="233" height="59" loading="eager" fetchpriority="high" />
                    <?php
                    else :
                        echo esc_attr(get_bloginfo('name', 'display'));
                    endif;
                    ?>

                    <?php
                    if (is_home() || is_front_page() && !empty($logo_dark)) :
                    ?>
                        <img class="main-logo main-logo-dark" src="<?php echo esc_url($logo_dark); ?>" alt="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" width="233" height="59" loading="eager" fetchpriority="high" />
                    <?php
                    endif;
                    ?>

                </a>
            </div>

            <nav class="header__menu-top navbar navbar-expand">

                <?php
                // Loading WordPress Custom Menu (theme_location).
                wp_nav_menu(
                    array(
                        'menu_class'     => 'navbar-nav',
                        'container'      => '',
                        'fallback_cb'    => 'WP_Bootstrap_Navwalker::fallback',
                        'walker'         => new WP_Bootstrap_Navwalker(),
                        'theme_location' => 'main-menu',
                    )
                );
                ?>

            </nav>

            <div class="header__toggler">

                <button href="#menuoffcanvas" role="button" data-bs-toggle="offcanvas" data-bs-target="#menuoffcanvas" aria-controls="menuoffcanvas" title="Menú" class="btn hamburguer-toggler">

                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="toggler-container">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M3 18h18v-2H3v2Zm0-5h18v-2H3v2Zm0-7v2h18V6H3Z" />
                    </svg> </symbol>

                </button>

            </div>

        </div>


        <!-- <div class="header-main-nav">

            <a class="navbar-brand logo-navbar" id="logo-edition-nav" href="<?php echo $edition_url; ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home">

                <?php
                if (!empty($logo)) :
                ?>
                    <img class="logo-navbar__img" src="<?php echo esc_url($logo); ?>" alt="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" width="140" height="41" loading="eager" fetchpriority="high" />
                <?php
                endif;
                ?>
            </a>

            <div class="header__menu-main-container">

                <nav class="header__menu-main navbar navbar-expand">

                    <?php
                    // Loading WordPress Custom Menu (theme_location).
                    wp_nav_menu(
                        array(
                            'menu_class'     => 'navbar-nav',
                            'container'      => '',
                            'fallback_cb'    => 'WP_Bootstrap_Navwalker::fallback',
                            'walker'         => new WP_Bootstrap_Navwalker(),
                            'theme_location' => 'main-menu',
                        )
                    );
                    ?>

                </nav>

            </div>
        </div> -->

    </div>
    <?php
    do_action('wa_inner_header_bottom');
    ?>
</header>