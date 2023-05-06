<?php

use App\Models\Customer;

$customer = new Customer();
$customer->find($id);
if ($customer->delete()) {
    header('Location: /customer');
    return;
}
echo 'gagal';