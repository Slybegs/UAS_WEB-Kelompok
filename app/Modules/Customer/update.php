<?php

use App\Models\Customer;

$customer = new Customer();
$customer->find($id);
$customer->fill($_POST);
if ($customer->save()) {
    header('Location: /customer');
    return;
}
header('Location: /customer/create');