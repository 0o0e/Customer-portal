<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
{
    protected $table = 'catalog';

    protected $fillable = [
        'MAIN CUSTOMER',
        'Customer No#',
        'Item Description',
        'Item Catalog',
        'Description',
        'Sales Unit of Measure',
        'Valid from Date',
        'Valid to Date'
    ];

    public function getRelatedCustomers($mainCustomer)
    {
        return $this->where('MAIN CUSTOMER', $mainCustomer)
            ->select('Customer No#')
            ->distinct()
            ->get();
    }

    public function getFilteredProducts($mainCustomer, $selectedCustomers = null)
    {
        $query = $this->where('Customer No#', $mainCustomer);

        if (!empty($selectedCustomers)) {
            $query->orWhere(function($q) use ($selectedCustomers) {
                foreach ($selectedCustomers as $customer) {
                    $q->orWhere('Customer No#', $customer);
                }
            });
        }

        return $query->get();
    }
    
}
