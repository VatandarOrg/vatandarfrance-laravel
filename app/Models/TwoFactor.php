<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Kavenegar;

class TwoFactor extends Model
{
    const CODE_EXPIRY = 120; //seconds

    protected $fillable = [
        'user_id',
        'code'
    ];

    public static function schema()
    {
        Schema::create('two_factors', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->unique();
            $table->char('code', 10);
            $table->timestamps();
        });
    }

    public static function generateCodeFor(User $user)
    {
        $user->code()->delete();

        $code = (app()->isLocal()) ? 1234 : mt_rand(1000, 9999);

        return static::create([
            'user_id' => $user->id,
            'code' => $code
        ]);
    }

    public function getCodeForSendAttribute()
    {
        return $this->code;
    }


    public function send()
    {
        if (app()->runningUnitTests() || app()->isLocal()) {
            return true;
        }
        try {
            $phone = $this->user->mobile;
            $text = $this->code;
            $receptor = "$phone";
            $template = "verifyenglish";
            $type = "sms";
            $token = $text;
            $token2 = $text;
            $token3 = "";
            $result = Kavenegar::VerifyLookup($receptor, $token, $token2, $token3, $template, $type);

            return true;
        } catch (\Throwable $th) {
            logger($th);
            return false;
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function isExpired()
    {
        return $this->created_at->diffInSeconds(now()) > static::CODE_EXPIRY;
    }


    public function isEqualWith($code)
    {
        return $this->code == $code;
    }
}
