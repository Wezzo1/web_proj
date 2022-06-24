<?php

namespace App\Models;

use App\Http\Controllers\CategoryController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Films extends Model
{
    use HasFactory;
    protected  $table=('films');

    public function categoryFilms(){
        return $this->belongsTo(category::class,'categoryid');
    }
}
