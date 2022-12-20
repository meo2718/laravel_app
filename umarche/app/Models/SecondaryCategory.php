<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use APP\Models\PrimaryCategory;

class SecondaryCategory extends Model
{
    use HasFactory;

    public function primary()
    {
        //primaryに属する
        return $this->belongsTo(PrimaryCategory::class);
    }
}
