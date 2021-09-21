<?php
/*
 *  Plugin Name:    K&H Bee Birthday Manager
 *  Plugin URI:     https://schrockinteractive.com/
 *  Description:    Provides a table with the birthday dates of registered customers.
 *  Author:         nalcaraz@schrockinteractive.com
 *  Version:        1.0
 *  Author URI:     https://schrockinteractive.com/
 *  Text Domain:    kandhbee
*/

/**
 * Built-in include guard removal
 * Just in case the client has a local dependency with the same file name.
 */

include('includes.php');

if (!defined('ABSPATH')) {
    die();
}

// Custom include-guard to ensure we don't duplicate.
if (!class_exists('BirthdayManager')) {

    class BirthdayManager
    {
        public function __construct()
        {

        }

        // Getters section.

        // Methods section.
    }


    /**
     * Renders the button into the admin menu with a fancy birthday cake icon.
     */
    function attachBirthdayMenu()
    {
        add_menu_page('Birthday Manager', 'Birthday Manager', 'unfiltered_html', 'KHB-Birthday-Manager', 'renderTableTemplate', 'dashicons-buddicons-community');
    }

    add_action('admin_menu', 'attachBirthdayMenu');

    /**
     * Renders the birthdays table with the query data of the Flamingo post contents.
     * See renderTableData() to check how the data is parsed.
     */
    function renderTableTemplate()
    {

        global $wpdb;

        $query = "SELECT * FROM " . $wpdb->prefix . "posts WHERE post_type='flamingo_inbound'  and post_title LIKE '%-%-%'";

        $data = $wpdb->get_results($query);

        // Header frame.
        echo '
			<div class="limiter">
				<div class="container-table100">
					<div class="wrap-table100">
						<div class="table100">
							<table class="birthday-table">
								<thead>
									<tr class="table100-head">
										<th class="column1">Username</th>
										<th class="column2">Birthday Date</th>
										<th class="column3">Age</th>
										<th class="column3">Days to birthdate</th>
										<th class="column3">Contact</th>
										<th class="column4">Joined at</th>
									</tr>
								</thead>
								<tbody class="birthday-table-body">';

        // Join together all query's data into an array of multiples arrays for each customer.
        $data_array = parseUsersInfo($data);

        $users_data_array = addAgeAndDaysToBirthdate($data_array);

        // Sort the multidimensional array.
        usort($users_data_array, 'compareDates');

        foreach ($users_data_array as &$users_info) {
            renderTableData($users_info);
        }

        // Footer frame.
        echo '
        						</tbody>
        					</table>
        				</div>
        			</div>
        		</div>
        	</div>';
    }

    /**
     * Render and show the array data from the query's result.
     */
    function renderTableData($users_info)
    {
        echo '
        	<tr>
            	<td class="column1">' . $users_info[0] . '</td>
            	<td class="column2">' . $users_info[2] . '</td>
            	<td class="column2">' . $users_info[3] . '</td>
            	<td class="column2">' . $users_info[4] . '</td>
            	<td class="column3">' . $users_info[1] . '</td>
            	<td class="column4">' . $users_info[7] . ' ' . $users_info[8] . '</td>
			</tr>
        ';
    }

    add_action('admin_head', 'attachTableStylesheet');
}