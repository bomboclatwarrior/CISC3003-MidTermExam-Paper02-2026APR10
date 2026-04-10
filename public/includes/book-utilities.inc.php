<?php
/**
 * Reads customers from semicolon-delimited text file.
 * Each line: id;first_name;last_name;email;university;address;city;state;country;zip;phone;sales
 * Sales are 12 comma-separated numbers.
 *
 * @param string $filename Path to customers.txt
 * @return array Associative array of customers
 */
function readCustomers($filename) {
    $customers = [];
    if (!file_exists($filename)) {
        return $customers;
    }
    $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $fields = explode(';', trim($line));
        if (count($fields) >= 12) {
            $customers[] = [
                'id'         => trim($fields[0]),
                'first_name' => trim($fields[1]),
                'last_name'  => trim($fields[2]),
                'email'      => trim($fields[3]),
                'university' => trim($fields[4]),
                'address'    => trim($fields[5]),
                'city'       => trim($fields[6]),
                'state'      => trim($fields[7]),
                'country'    => trim($fields[8]),
                'zip'        => trim($fields[9]),
                'phone'      => trim($fields[10]),
                'sales'      => trim($fields[11])
            ];
        }
    }
    return $customers;
}

/**
 * Reads orders from semicolon-delimited text file and returns those matching a customer ID.
 * Each line: order_id;customer_id;isbn;title;category
 *
 * @param string $customerId The customer ID to filter
 * @param string $filename Path to orders.txt
 * @return array Array of orders for that customer
 */
function readOrders($customerId, $filename) {
    $orders = [];
    if (!file_exists($filename)) {
        return $orders;
    }
    $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $fields = explode(';', trim($line));
        if (count($fields) >= 5) {
            if (trim($fields[1]) == $customerId) {
                $orders[] = [
                    'order_id'    => trim($fields[0]),
                    'customer_id' => trim($fields[1]),
                    'isbn'        => trim($fields[2]),
                    'title'       => trim($fields[3]),
                    'category'    => trim($fields[4])
                ];
            }
        }
    }
    return $orders;
}
?>