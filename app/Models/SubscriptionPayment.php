<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SubscriptionPayment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'paypal_subscription_id',
        'callback_data',
        'plan_id',
        'status',
        'subscriber',
        'detail',
        'start_time',
        'expired_at',
    ];

    protected $casts = [
        "callback_data" => "array",
        "subscriber" => "array",
        "detail" => "array"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscription(): HasOne
    {
        return $this->hasOne(Subscription::class);
    }

    static function schema()
    {
        Schema::create('subscription_payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained();

            $table->string('paypal_subscription_id');
            $table->string('plan_id');
            $table->string('status');

            $table->json('callback_data')->nullable();
            $table->json('subscriber')->nullable();
            $table->json('detail')->nullable();
            $table->timestamp('start_time')->nullable();
            $table->timestamp('expired_at')->nullable();

            $table->softDeletes();

            $table->timestamps();
        });
    }
}
