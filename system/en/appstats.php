<?php

    require_once './config.php';
    define('APIAUTH', '$!@#$VLs@#$%u6#@$%R4df&^$&SWHtJW@$#');

    $Url = (isset($_GET['show']) ? $_GET['show'] : false);
    $start_date = (isset($_GET['start_date']) ? $_GET['start_date'] : false);
    $end_date = (isset($_GET['end_date']) ? $_GET['end_date'] : false);


    if ($Url == 'get_clients') {
        $clients_query = $con->query("SELECT clients.*, "
                . " COUNT(client_fav.fav_id) as count_client_fav, "
                . " COUNT(orders.order_id) as count_client_orders, "
                . " COUNT(sub_category_comments.comment_id) as count_client_comments "
                . " FROM clients "
                . " LEFT JOIN client_fav on client_fav.client_id = clients.client_id "
                . " LEFT JOIN orders on orders.client_id = clients.client_id "
                . " LEFT JOIN sub_category_comments on sub_category_comments.client_id= clients.client_id "
                . " GROUP BY clients.client_id ");
        $clients = [];
        while ($clients_date = \mysqli_fetch_object($clients_query)) {
            $clients[] = $clients_date;
        }
        header('Content-Type: application/json; charset=utf-8');
        if (isset($_SERVER['HTTP_APIAUTH']) && $_SERVER['HTTP_APIAUTH'] == APIAUTH) {
            echo \json_encode($clients);
        } else {
            echo \json_encode([
                'error' => 'Authentication code not found'
            ]);
        }
        die();
    }

    /*
     * Start Get Data By Date
     */
    if ($start_date == false) {
        $start_date = new DateTime(\date('Y-m-d 00:00:00'));
        $start_date = $start_date->format('Y-m-d 00:00:00');
    } else {
        $start_date = new DateTime($start_date);
        $start_date = $start_date->format('Y-m-d 00:00:00');
    }
    if ($end_date == false) {
        $end_date = new DateTime(\date('Y-m-d 23:59:59'));
        $end_date = $end_date->format('Y-m-d 23:59:59');
    } else {
        $end_date = new DateTime($end_date);
        $end_date = $end_date->format('Y-m-d 23:59:59');
    }

    $count_by_date_query = $con->query("SELECT COUNT(order_id) as count_by_date , SUM(net_price) as totle_price_by_date FROM orders where orders.date BETWEEN  '" . $start_date . "' and '" . $end_date . "'");
    $count_by_date = \mysqli_fetch_object($count_by_date_query);
    /*
     * **************** End*********************
     */

    /*
     * Start Get count of clients
     */
    $clients_query = $con->query('SELECT COUNT(client_id) clients FROM clients');
    $clients_rows = \mysqli_fetch_object($clients_query);
    /*
     * **************** End*********************
     */

    /*
     * Start Get count of clients
     */
    $active_clients_query = $con->query('SELECT clients.client_id, clients.client_name, COUNT(orders.client_id) as active_clients FROM clients LEFT JOIN orders ON (orders.client_id = clients.client_id) WHERE orders.order_id > 0 GROUP BY clients.client_name');
    $active_clients_num_rows = \mysqli_num_rows($active_clients_query);
    /*
     * **************** End*********************
     */
    $_late_date = new DateTime(\date('Y-m-d H:i:s'));
    $_late_date->modify('-90 minutes');
    $_late_date_strat = $_late_date->format('Y-m-d H:i:s');

    $_late_date = new DateTime(\date('Y-m-d H:i:s'));
    $_late_date->modify('-5 minutes');
    $_late_date_end = $_late_date->format('Y-m-d H:i:s');


    $orders_query = $con->query(
            'SELECT '
            . "(SELECT COUNT(order_id) as to_late FROM orders where orders.order_status=0 AND orders.date BETWEEN '" . $_late_date_strat . "' and '" . $_late_date_end . "' ) as to_late"
            . ' , (SELECT COUNT(order_id) as approved FROM orders where order_status=1) as approved'
            . ' , (SELECT SUM(net_price) as approved_totle_price FROM orders ) as approved_totle_price'
            . ' , (SELECT COUNT(order_id) as not_approved FROM orders where order_status=2) as not_approved'
    );
    $orders_rows = \mysqli_fetch_object($orders_query);
    $orders_error = \mysqli_error($con);

    $json_data = [
        'clients' => $clients_rows->clients,
        'active_clients' => $active_clients_num_rows,
        'orders' => [
            'approved_totle_price' => $orders_rows->approved_totle_price,
            'totale_orders' => ($orders_rows->approved + $orders_rows->not_approved),
            'totle_price_by_date' => ($count_by_date->totle_price_by_date),
            'count_by_date' => ($count_by_date->count_by_date),
            'to_late' => $orders_rows->to_late,
            'approved' => $orders_rows->approved,
            'not_approved' => $orders_rows->not_approved,
    ]];

    header('Content-Type: application/json; charset=utf-8');
    if (isset($_SERVER['HTTP_APIAUTH']) && $_SERVER['HTTP_APIAUTH'] == APIAUTH) {
        echo \json_encode($json_data);
    } else {
        echo \json_encode([
            'error' => 'Authentication code not found'
        ]);
    }

