<?php
/**
 * Header Navigation Template
 *
 * @package Asgard
 */
$menu_class = \ASGARD_THEME\Inc\Menus::get_instance();
$header_menu_id = $menu_class->get_menu_id('asgard-main-menu');

$header_menus = wp_get_nav_menu_items($header_menu_id);
?>
<nav class="navbar main-navbar navbar-expand-lg navbar-light bg-white py-3">
    <div class="container">
        <button class="navbar-toggler p-2 ms-n2" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <svg fill="#000000" width="24" height="24"><use href="#icon-bars"></use></svg>
        </button>
        <?php
        if ( function_exists( 'the_custom_logo' ) ) {
            the_custom_logo();
        }
        ?>
        <ul class="d-flex list-unstyled align-items-center m-0 d-lg-none">
                <li class="me-1">
                    <a href="#offcanvasSearch" data-bs-toggle="offcanvas" role="button" aria-controls="offcanvasSearch"><svg width="24" height="24" fill="#000"><use href="#icon-search"></use></svg></a>
                </li>
                <li class="mini-cart-counter">
                    <a id="cart_badge" class="mini-cart" href="#offcanvasCart" class="m-0 d-flex text-decoration-none align-items-center" data-bs-toggle="offcanvas" aria-controls="offcanvasCart">
                        <div class="position-relative p-0 cart-icon-button d-flex justify-content-center align-items-center h-auto w-auto">
                            <svg width="24" height="24" fill="#000"><use href="#icon-basket"></use></svg>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary fw-normal">
                                <?php echo esc_html( WC()->cart->cart_contents_count ); ?>
                                <span class="visually-hidden">New alerts</span>
                            </span>
                        </div>
                    </a>
                </li>
            </ul>
        <div class="collapse navbar-collapse d-none d-lg-block" id="navbarSupportedContent">
            <?php if( !empty($header_menus) && is_array($header_menus)) { ?>
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <?php foreach ($header_menus as $menu_item) {
                        $active = ($menu_item->object_id == get_queried_object_id()) ? 'active' : '';
                        if (!$menu_item->menu_item_parent) {
                            $child_menu_items = $menu_class->get_child_menu_items($header_menus, $menu_item->ID);
                            $has_children = !empty($child_menu_items) && is_array($child_menu_items);
                            $has_sub_menu_class = $has_children ? 'has-submenu' : '';
                            $link_target = !empty($menu_item->target) && '_blank' === $menu_item->target ? '_blank' : '_self';
                            if (!$has_children) { ?>
                                <li class="nav-item">
                                    <a class="text-capitalize fw-medium nav-link text-decoration-none rounded-5 mx-lg-0 mx-xl-2 <?php echo $active; ?>" target="<?php echo esc_attr($link_target); ?>" href="<?php echo esc_url($menu_item->url); ?>">
                                        <?php echo esc_html($menu_item->title); ?>
                                    </a>
                                </li>
                            <?php } else { ?>
                                <li class="nav-item dropdown">
                                    <a class="text-uppercase fs-14 nav-link dropdown-toggle px-lg-3 px-md-0 fw-semibold" href="<?php echo esc_url($menu_item->url); ?>" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <?php echo esc_html($menu_item->title); ?>
                                    </a>
                                    <ul class="dropdown-menu shadow" aria-labelledby="navbarDropdown">
                                        <?php foreach ($child_menu_items as $child_menu_item) {
                                            $activeChild = ($child_menu_item->object_id == get_queried_object_id()) ? 'active' : ''; ?>
                                            <li class="sub-menu-items"><a class="fs-14 dropdown-item px-3 text-decoration-none fw-semibold <?php echo $activeChild; ?>" href="<?php echo esc_url($child_menu_item->url); ?>">
                                                    <?php echo esc_html($child_menu_item->title); ?>
                                                </a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </li>
                            <?php }
                        }
                    }
                    if (is_user_logged_in()) {
                        // Logged-in users get a Logout link
                        if ( class_exists( 'WooCommerce' ) ) {
                            echo '<li class="nav-item"><a class="text-capitalize fw-medium nav-link nav-link text-decoration-none rounded-5 mx-lg-0 mx-xl-2 " href="' . wp_logout_url(get_permalink( get_option('woocommerce_myaccount_page_id') )) . '">Logout</a></li>';
                        } else {
                            echo '<li class="nav-item"><a class="text-capitalize fw-medium nav-link nav-link text-decoration-none rounded-5 mx-lg-0 mx-xl-2 " href="' . wp_logout_url(home_url()) . '">Logout</a></li>';
                        }

                    } else {
                        // Guests get a Login link
                        if ( class_exists( 'WooCommerce' ) ) {
                            echo '<li class="nav-item"><a class="text-capitalize fw-medium nav-link nav-link text-decoration-none rounded-5 mx-lg-0 mx-xl-2 " href="' . get_permalink( get_option('woocommerce_myaccount_page_id') ) . '">Login/Register</a></li>';
                        } else {
                            echo '<li class="nav-item"><a class="text-capitalize fw-medium nav-link nav-link text-decoration-none rounded-5 mx-lg-0 mx-xl-2 " href="' . wp_login_url() . '">Login</a></li>';
                        }
                    }
                    ?>
                </ul>
            <?php } ?>
            <ul class="d-flex list-unstyled align-items-center mb-0 three-cons">
                <li class="me-1 user-menu dropdown-center">
                    <a href="#" id="userMenuDropdown" class="dropdown-toggle no-caret" role="button" data-bs-toggle="dropdown" aria-expanded="false"><svg width="24" height="24" fill="#000"><use href="#icon-user"></use></svg></a>
                    <ul class="dropdown-menu dropdown-menu-end px-2 py-3 border-0 rounded-0">
                    <?php if ( class_exists( 'WooCommerce' ) ) : ?>
                        <?php if ( is_user_logged_in() ) : ?>
                            <li>
                                <a class="dropdown-item bg-transparent text-dark text-decoration-none fw-medium" href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>">
                                    <svg width="19" height="19" class="me-1">
                                        <use href="#icon-user"></use>
                                    </svg> My account
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item bg-transparent text-dark text-decoration-none fw-medium" href="<?php echo esc_url( wc_get_cart_url() ); ?>">
                                    <svg width="19" height="19" class="me-1">
                                        <use href="#icon-bag"></use>
                                    </svg> View cart
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item bg-transparent text-dark text-decoration-none fw-medium" href="<?php echo esc_url( wp_logout_url( home_url() ) ); ?>">
                                    <svg width="19" height="19" class="me-1">
                                        <use href="#icon-logout"></use>
                                    </svg> Logout
                                </a>
                            </li>
                        <?php else : ?>
                            <li>
                                <a class="dropdown-item bg-transparent text-dark text-decoration-none fw-medium" href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>">
                                    <svg width="19" height="19" class="me-1">
                                        <use href="#icon-login"></use>
                                    </svg> Login
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item bg-transparent text-dark text-decoration-none fw-medium" href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>">
                                    <svg width="19" height="19" class="me-1">
                                        <use href="#icon-register"></use>
                                    </svg> Register
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>

                    </ul>
                </li>
                <li class="me-1">
                    <a href="#offcanvasSearch" data-bs-toggle="offcanvas" role="button" aria-controls="offcanvasSearch"><svg width="24" height="24" fill="#000"><use href="#icon-search"></use></svg></a>
                </li>
                <li class="mini-cart-counter">
                    <?php echo asgard_mini_cart(); ?>
                </li>
            </ul>
        </div>

        <!-- Mobile Offcanvas Menu -->
        <div class="offcanvas offcanvas-start d-lg-none bg-white" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <!-- <h5 class="offcanvas-title" id="offcanvasNavbarLabel"></h5> -->
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3 m-0">
                    <?php foreach ($header_menus as $menu_item) {
                        $active = ($menu_item->object_id == get_queried_object_id()) ? 'active' : '';
                        if (!$menu_item->menu_item_parent) {
                            $child_menu_items = $menu_class->get_child_menu_items($header_menus, $menu_item->ID);
                            $has_children = !empty($child_menu_items) && is_array($child_menu_items);
                            if (!$has_children) { ?>
                                <li class="nav-item my-2">
                                    <a class="nav-link text-capitalize fw-medium py-2 text-decoration-none rounded-5 <?php echo $active; ?>" href="<?php echo esc_url($menu_item->url); ?>">
                                        <?php echo esc_html($menu_item->title); ?>
                                    </a>
                                </li>
                            <?php } else { ?>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <?php echo esc_html($menu_item->title); ?>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <?php foreach ($child_menu_items as $child_menu_item) {
                                            $activeChild = ($child_menu_item->object_id == get_queried_object_id()) ? 'active' : ''; ?>
                                            <li><a class="dropdown-item <?php echo $activeChild; ?>" href="<?php echo esc_url($child_menu_item->url); ?>">
                                                    <?php echo esc_html($child_menu_item->title); ?>
                                                </a></li>
                                        <?php } ?>
                                    </ul>
                                </li>
                            <?php }
                        }
                    }
                    if (is_user_logged_in()) {
                        // Logged-in users get a Logout link
                        if ( class_exists( 'WooCommerce' ) ) {
                            echo '<li class="nav-item my-2"><a class="text-capitalize fw-medium nav-link py-2 text-decoration-none rounded-5 " href="' . wp_logout_url(get_permalink( get_option('woocommerce_myaccount_page_id') )) . '">Logout</a></li>';
                        } else {
                            echo '<li class="nav-item my-2"><a class="text-capitalize fw-medium nav-link py-2 text-decoration-none rounded-5 " href="' . wp_logout_url(home_url()) . '">Logout</a></li>';
                        }

                    } else {
                        // Guests get a Login link
                        if ( class_exists( 'WooCommerce' ) ) {
                            echo '<li class="nav-item my-2"><a class="text-capitalize fw-medium nav-link py-2 text-decoration-none rounded-5 " href="' . get_permalink( get_option('woocommerce_myaccount_page_id') ) . '">Login/Register</a></li>';
                        } else {
                            echo '<li class="nav-item my-2"><a class="text-capitalize fw-medium nav-link py-2 text-decoration-none rounded-5 " href="' . wp_login_url() . '">Login</a></li>';
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</nav>