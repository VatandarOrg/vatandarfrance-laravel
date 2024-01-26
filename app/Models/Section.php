<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'priority'
    ];
    
    static function schema()
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('priority')->default(1);
            $table->timestamps();
        });
    }
}
