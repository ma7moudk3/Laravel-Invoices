<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class products extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        "product_name",
        "description",
        "created_by",
        "section_id"
    ];

    public function section()
    {
        return $this->belongsTo('App\Models\sections');
    }
}
