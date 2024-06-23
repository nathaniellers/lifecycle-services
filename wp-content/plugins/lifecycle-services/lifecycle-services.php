<?php
/*
Plugin Name: Lifecycle Services
Description: A plugin to manage lifecycle services.
Version: 1.0
Author: Your Name
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Enqueue necessary scripts and styles
function lifecycle_services_enqueue_scripts($hook) {
    if ($hook != 'toplevel_page_lifecycle-services') {
        return;
    }
    $tailwind_css_url = trailingslashit( site_url() ) . 'tailwind_output.css';
    // Add the tailwind styles
    wp_enqueue_style('tailwind-css', $tailwind_css_url, array(), '1.0', 'all');
    wp_enqueue_style('lifecycle-services-style', plugin_dir_url(__FILE__) . 'css/style.css');
    wp_enqueue_script('lifecycle-services-script', plugin_dir_url(__FILE__) . 'js/script.js', array('jquery'), null, true);
    wp_localize_script('lifecycle-services-script', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
}
add_action('admin_enqueue_scripts', 'lifecycle_services_enqueue_scripts');

// Add the admin menu
function lifecycle_services_add_admin_menu() {
    add_menu_page('Lifecycle Services', 'Lifecycle Services', 'manage_options', 'lifecycle-services', 'lifecycle_services_page');
}
add_action('admin_menu', 'lifecycle_services_add_admin_menu');

function custom_nav_sidebar_register_menu() {
    register_nav_menus(array(
        'custom-nav-menu' => __('Custom Navigation Menu'),
    ));
}
add_action('init', 'custom_nav_sidebar_register_menu');

function custom_nav_sidebar_menu() {
    wp_nav_menu(array(
        'theme_location' => 'custom-nav-menu',
        'menu_id'        => 'custom-nav-menu',
    ));
}

function custom_nav_sidebar_create_menu() {
    $menu_name = 'Custom Navigation Menu';
    $menu_exists = wp_get_nav_menu_object($menu_name);

    if (!$menu_exists) {
        $menu_id = wp_create_nav_menu($menu_name);

        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title'   => __('Home'),
            'menu-item-url'     => home_url('/'),
            'menu-item-status'  => 'publish',
        ));

        $vendor_id = wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title'   => __('Vendors'),
            'menu-item-url'     => '#',
            'menu-item-status'  => 'publish',
        ));

        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title'   => __('Add Vendor'),
            'menu-item-url'     => home_url('/add-vendor'),
            'menu-item-parent-id' => $vendor_id,
            'menu-item-status'  => 'publish',
        ));

        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title'   => __('Vendor List'),
            'menu-item-url'     => home_url('/vendor-list'),
            'menu-item-parent-id' => $vendor_id,
            'menu-item-status'  => 'publish',
        ));

        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title'   => __('Services'),
            'menu-item-url'     => home_url('/services'),
            'menu-item-status'  => 'publish',
        ));

        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title'   => __('Case Studies'),
            'menu-item-url'     => home_url('/case-studies'),
            'menu-item-status'  => 'publish',
        ));

        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title'   => __('Company'),
            'menu-item-url'     => home_url('/company'),
            'menu-item-status'  => 'publish',
        ));

        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title'   => __('Contact Us'),
            'menu-item-url'     => home_url('/contact-us'),
            'menu-item-status'  => 'publish',
        ));
    }
}
add_action('after_setup_theme', 'custom_nav_sidebar_create_menu');

function custom_nav_sidebar_widgets_init() {
    register_sidebar(array(
        'name'          => __('Org Chart Sidebar', 'custom-nav-sidebar'),
        'id'            => 'org-chart-sidebar',
        'before_widget' => '<div class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
}
add_action('widgets_init', 'custom_nav_sidebar_widgets_init');

function custom_nav_sidebar_enqueue_scripts() {
    wp_enqueue_script('custom-nav-sidebar-js', plugins_url('/js/custom-nav-sidebar.js', __FILE__), array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'custom_nav_sidebar_enqueue_scripts');

function custom_nav_sidebar_shortcode() {
    return '<div id="org-chart-sidebar"></div>';
}
add_shortcode('org_chart_sidebar', 'custom_nav_sidebar_shortcode');


// Create the admin page
function lifecycle_services_page() {
    ?>
    <div class="mt-5 pr-3">
        <div class="w-full px-[150px]">
            <ul class="flex flex-row justify-evenly">
                <li><a class="nav-options [&.active]:bg-blue-400 [&.active]:border-md [&.active]:text-white py-2 px-3" href="/">Home</a></li>
                <li><a class="nav-options [&.active]:bg-blue-400 [&.active]:border-md [&.active]:text-white py-2 px-3" href="/vendors">Vendors</a></li>
                <li><a class="nav-options [&.active]:bg-blue-400 [&.active]:border-md [&.active]:text-white py-2 px-3" href="/services">Services</a></li>
                <li><a class="nav-options [&.active]:bg-blue-400 [&.active]:border-md [&.active]:text-white py-2 px-3" href="/case-studies">Case Studies</a></li>
                <li><a class="nav-options [&.active]:bg-blue-400 [&.active]:border-md [&.active]:text-white py-2 px-3" href="/company">Company</a></li>
                <li><a class="nav-options [&.active]:bg-blue-400 [&.active]:border-md [&.active]:text-white py-2 px-3" href="/contact">Contact Us</a></li>
            </ul>
        </div>
        <div class="relative flex">
            <div class="flex flex-col">

                <ul class="w-full">
                    <li class="w-full relative pt-5 px-3 pb-0 float-left text-center list-none">
                        <a class="hover:text-white hover:bg-[#0769b0] text-[#0b83d9] font-semibold bg-[#d5e6f1] max-w-[320px] w-full inline-block py-2 px-3 border rounded-md no-underline color-[#ccc] text-sm" href="#">All Lifecycle Services</a>
                        <ul class="w-[200px] flex justify-center before:content-[''] before:absolute before:left-2/4 before:w-0 before:h-5 before:border-2 before:border-l before:border-[#0b83d9]">
                            <li class="w-full relative pt-5 px-2 pb-0 float-left flex flex-col items-center list-none">
                                <a class="hover:text-white hover:bg-[#0769b0] text-[#0b83d9] font-semibold bg-[#d5e6f1] max-w-[150px] w-full inline-block py-2 px-3 border rounded-md no-underline color-[#ccc] text-sm" href="#">Advisory</a>
                                <ul class="w-[200px] flex justify-center before:content-[''] before:absolute before:left-2/4 before:w-0 before:h-5 before:border-2 before:border-l before:border-[#0b83d9]">
                                    <li class="w-full relative pt-5 px-2 pb-0 float-left flex flex-col items-center list-none">
                                        <a class="hover:text-white hover:bg-[#0769b0] text-[#0b83d9] font-semibold bg-[#d5e6f1] max-w-[150px] w-full inline-block py-2 px-3 border rounded-md no-underline color-[#ccc] text-sm" href="#">Design</a>
                                        <ul class="w-[200px] flex justify-center before:content-[''] before:absolute before:left-2/4 before:w-0 before:h-5 before:border-2 before:border-l before:border-[#0b83d9]">
                                            <li class="w-full relative pt-5 px-2 pb-0 float-left flex flex-col items-center list-none">
                                                <a class="hover:text-white hover:bg-[#0769b0] text-[#0b83d9] font-semibold bg-[#d5e6f1] max-w-[150px] w-full inline-block py-2 px-3 border rounded-md no-underline color-[#ccc] text-sm" href="#">Implementation</a>
                                                <ul class="w-[200px] flex justify-center before:content-[''] before:absolute before:left-2/4 before:w-0 before:h-5 before:border-2 before:border-l before:border-[#0b83d9]">
                                                    <li class="w-full relative pt-5 px-2 pb-0 float-left flex flex-col items-center list-none">
                                                        <a class="hover:text-white hover:bg-[#0769b0] text-[#0b83d9] font-semibold bg-[#d5e6f1] max-w-[150px] w-full inline-block py-2 px-3 border rounded-md no-underline color-[#ccc] text-sm" href="#">Support</a>
                                                        <ul class="w-[200px] flex justify-center before:content-[''] before:absolute before:left-2/4 before:w-0 before:h-5 before:border-2 before:border-l before:border-[#0b83d9]">
                                                            <li class="w-full relative pt-5 px-2 pb-0 float-left flex flex-col items-center list-none">
                                                                <a class="hover:text-white hover:bg-[#0769b0] text-[#0b83d9] font-semibold bg-[#d5e6f1] max-w-[150px] w-full inline-block py-2 px-3 border rounded-md no-underline color-[#ccc] text-sm" href="#">Assessments</a>
                                                                <ul class="w-[200px] flex justify-center before:content-[''] before:absolute before:left-2/4 before:w-0 before:h-5 before:border-2 before:border-l before:border-[#0b83d9]">
                                                                    <li class="w-full relative pt-5 px-2 pb-0 float-left flex flex-col items-center list-none">
                                                                        <a class="hover:text-white hover:bg-[#0769b0] text-white bg-[#d5e6f1] max-w-[150px] w-full inline-block py-2 px-3 border rounded-md no-underline color-[#ccc] text-sm" href="#">Trainings</a>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
           
            <div id="lifecycle-services-content pr-3 mt-5">
                <div class="flex justify-between items-center">
                    <h1 class="m-0 text-2xl font-bold">Lifecycle Services</h1>
                    <input class="float-right" type="text" placeholder="Search">
                </div>
                <p>From strategy to operate services for your IT/IoT network and cyber security solutions</p>
                <div class="mt-5">

                    <select class="filter-options" id="technology"></select>
                    <select class="filter-options" id="subtechnology"></select>
                    <select class="filter-options" id="vendor"></select>
                    <select class="filter-options" id="product"></select>
                </div>
                <!-- <button id="export-to-excel">Export to Excel</button>
                <input type="file" id="excel-file" name="excel_file">
                <button id="import-from-excel">Import from Excel</button>
                <button id="print-report">Print Report</button> -->
                <div id="card-container" class="mt-5">
                    <!-- Example service item -->
                    <div class="border border-[#ddd] p-3 rounded-md bg-white">
                        <h2>DNA Center Assurance Implementation</h2>
                        <p>Expert guidance and recommendations to organizations on how to design, implement, and maintain secure and efficient network infrastructures.</p>
                        <span>SKU: EN-S-</span>
                    </div>
                    <!-- More service items can be dynamically generated here -->
                </div>
            </div>
        </div>
    </div>
    <?php
}

// Handle export to Excel
function lifecycle_services_export_to_excel() {
    // Example data to export
    $data = [
        ['ID', 'Service', 'Description'],
        [1, 'DNA Center Assurance Implementation', 'Expert guidance...'],
        // Add more data as needed
    ];

    // Generate the Excel file
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="lifecycle-services.xls"');

    foreach ($data as $row) {
        echo implode("\t", $row) . "\n";
    }
    exit;
}
add_action('wp_ajax_lifecycle_services_export_to_excel', 'lifecycle_services_export_to_excel');

// Handle import from Excel
function lifecycle_services_import_from_excel() {
    if (!empty($_FILES['excel_file']['name'])) {
        $uploaded_file = $_FILES['excel_file']['tmp_name'];
        // Process the uploaded file
        // ...
        echo 'File imported successfully';
    } else {
        echo 'No file uploaded';
    }
    exit;
}
add_action('wp_ajax_lifecycle_services_import_from_excel', 'lifecycle_services_import_from_excel');
?>
