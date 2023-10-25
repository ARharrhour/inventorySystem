<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{


    protected $fillable=["product_name","product_code","category_id","supplier_id","root","buying_price","selling_price",
                        "product_quantity","image","buying_date"];
}
