<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;
    protected $table='wishlists';
    protected $primaryKey='id';
    protected $fillable=[
        'product_id',
        'user_id'
    ];

    

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
}
