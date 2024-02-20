<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Box\BoxWithoutRelationResource;
use App\Http\Resources\Api\V1\Slider\SliderWithoutRelationResource;
use App\Http\Resources\Api\V1\Post\PostWithoutRelationResource;
use App\Models\Section;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Contracts\Database\Eloquent\Builder;

class HomeController extends Controller
{
    public function __invoke(Request $request)
    {
        $sections = Section::with(['boxes' => function (Builder $query) use ($request) {
            $query->where('lang', $request->language)->orderBy('priority', 'asc');
        }, 'posts' => function (Builder $query) use ($request) {
            $query->where('lang', $request->language)->orderBy('priority', 'asc');
        }])->orderBy('priority', 'asc')->get()->map(function ($value) {
            $boxes = BoxWithoutRelationResource::collection($value->boxes);
            $posts = PostWithoutRelationResource::collection($value->posts);
            return [$value->name => $boxes->merge($posts)];
        });

        $newData = [];
        foreach ($sections as $item) {
            foreach ($item as $key => $value) {
                $newData[$key] = $value;
            }
        }
        $sliders = Slider::where('lang', $request->language)->orderBy('priority', 'asc')->get();
        return ['splashscreens' => ['lightmode' => "https://vatandar.fr/lightmode.json", 'darkmode' => "https://vatandar.fr/darkmode.fr"], 'slides' => SliderWithoutRelationResource::collection($sliders)] + $newData;
    }
}
