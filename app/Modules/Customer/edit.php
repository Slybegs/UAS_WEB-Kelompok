<?php

use App\Models\Customer;

$customer = new Customer();
$customer->find($id);

echo $twig->render('customer/edit.html.twig', ['customer' => $customer->toArray()]);