<?php

class SwpmPaymentsAdminMenu {

    function __construct() {

    }

    function handle_main_payments_admin_menu() {
        do_action('swpm_payments_menu_start');

        //Check current_user_can() or die.
        SwpmMiscUtils::check_user_permission_and_is_admin('Main Payments Admin Menu');

        $output = '';
        $tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : '';
        $selected = $tab;
        ?>


        <div class="wrap swpm-admin-menu-wrap"><!-- start wrap -->

            <h1><?php _e('Payments') ?></h1><!-- page title -->

            <!-- start nav menu tabs -->
            <h2 class="nav-tab-wrapper">
                <a class="nav-tab <?php echo ($tab == '') ? 'nav-tab-active' : ''; ?>" href="admin.php?page=simple_wp_membership_payments"><?php _e('Transactions', 'simple-membership'); ?></a>
                <a class="nav-tab <?php echo ($tab == 'payment_settings') ? 'nav-tab-active' : ''; ?>" href="admin.php?page=simple_wp_membership_payments&tab=payment_settings"><?php _e('Payment Settings', 'simple-membership'); ?></a>
                <a class="nav-tab <?php echo ($tab == 'payment_buttons') ? 'nav-tab-active' : ''; ?>" href="admin.php?page=simple_wp_membership_payments&tab=payment_buttons"><?php _e('Manage Payment Buttons', 'simple-membership'); ?></a>
                <a class="nav-tab <?php echo ($tab == 'create_new_button') ? 'nav-tab-active' : ''; ?>" href="admin.php?page=simple_wp_membership_payments&tab=create_new_button"><?php _e('Create New Button', 'simple-membership'); ?></a>
                <?php
                if ($tab == 'edit_button') {//Only show the "edit button" tab when a button is being edited.
                    echo '<a class="nav-tab nav-tab-active" href="#">Edit Button</a>';
                }
                if ($tab == 'add_new_txn') {//Only show the "add txn manually" tab when a transaction is being added.
                    echo '<a class="nav-tab nav-tab-active" href="#">Add Transaction Manually</a>';
                }                
                if ($tab == 'edit_txn') {//Only show the "edit txn" tab when a transaction is being edited.
                    echo '<a class="nav-tab nav-tab-active" href="#">Edit/View Transaction</a>';
                }

                //Trigger hooks that allows an extension to add extra nav tabs in the payments menu.
                do_action ('swpm_payments_menu_nav_tabs', $selected);

                $menu_tabs = apply_filters('swpm_payments_menu_additional_menu_tabs_array', array());
                foreach ($menu_tabs as $menu_action => $title){
                    ?>
                    <a class="nav-tab <?php echo ($selected == $menu_action) ? 'nav-tab-active' : ''; ?>" href="admin.php?page=simple_wp_membership_payments&tab=<?php echo $menu_action; ?>" ><?php _e($title, 'simple-membership'); ?></a>
                    <?php
                }

                ?>
            </h2>
            <!-- end nav menu tabs -->

            <?php

            do_action('swpm_payments_menu_after_nav_tabs');

            //Allows an addon to completely override the body section of the payments admin menu for a given action.
            $output = apply_filters('swpm_payments_menu_body_override', '', $tab);
            if (!empty($output)) {
                //An addon has overriden the body of this page for the given tab/action. So no need to do anything in core.
                echo $output;
                echo '</div>';//<!-- end of wrap -->
                return;
            }

            echo '<div id="poststuff"><div id="post-body">';

            //TODO - move most of the following includes to functions of this class instead.

            //Switch case for the various different tabs handled by the core plugin.
            switch ($tab) {
                case 'payment_settings':
                    include_once(SIMPLE_WP_MEMBERSHIP_PATH . 'classes/admin-includes/class.swpm-payment-settings-menu-tab.php');
                    $payment_settings_tab = new SWPM_Payment_Settings_Menu_Tab();
                    $payment_settings_tab->handle_payment_settings_menu_tab();
                    break;                
                case 'payment_buttons':
                    include_once(SIMPLE_WP_MEMBERSHIP_PATH . '/views/payments/admin_payment_buttons.php');
                    break;
                case 'create_new_button':
                    include_once(SIMPLE_WP_MEMBERSHIP_PATH . '/views/payments/admin_create_payment_buttons.php');
                    break;
                case 'edit_button':
                    include_once(SIMPLE_WP_MEMBERSHIP_PATH . '/views/payments/admin_edit_payment_buttons.php');
                    break;
                case 'all_txns':
                    include_once(SIMPLE_WP_MEMBERSHIP_PATH . '/views/payments/admin_all_payment_transactions.php');
                    break;
                case 'add_new_txn':
                    include_once(SIMPLE_WP_MEMBERSHIP_PATH . '/views/payments/admin_add_edit_transaction_manually.php');
                    swpm_handle_add_new_txn_manually();
                    break;
                case 'edit_txn':
                    include_once(SIMPLE_WP_MEMBERSHIP_PATH . '/views/payments/admin_edit_transaction.php');
                    swpm_handle_edit_txn();
                    break;
                default:
                    include_once(SIMPLE_WP_MEMBERSHIP_PATH . '/views/payments/admin_all_payment_transactions.php');
                    break;
            }

            echo '</div></div>'; //<!-- end of post-body -->

        echo '</div>'; //<!-- end of .wrap -->
    }

}

