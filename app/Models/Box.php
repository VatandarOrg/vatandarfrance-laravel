<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Box extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'web_view',
        'link',
        'lang',
        'priority',
        'section_id',
        'color'
    ];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    static function schema()
    {
        Schema::create('boxes', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->boolean('web_view')->default(true);
            $table->string('link')->nullable();
            $table->string('color')->nullable();
            $table->string('lang')->default('fa');
            $table->integer('priority')->default(1);

            $table->unsignedBigInteger('section_id');
            $table->foreign('section_id')->references('id')->on('sections')->cascadeOnDelete();

            $table->timestamps();
        });
    }
}
