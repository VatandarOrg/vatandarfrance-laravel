<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'priority'
    ];

    public function boxes(): HasMany
    {
        return $this->hasMany(Box::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

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
