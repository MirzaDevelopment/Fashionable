<?php

namespace App\Providers;
use App\Models\User;
use App\Models\Product;
use App\Models\Color;
use App\Models\Gender;
use App\Models\Heel;
use App\Models\Image;
use App\Models\Material;
use App\Models\Price;
use App\Models\Size;
use App\Models\Tag;
use App\Models\Type;
use App\Models\Wishlist;
use App\Models\Question;
// use Illuminate\Support\Facades\Gate;

use App\Policies\UserPolicy;
use App\Policies\ColorPolicy;
use App\Policies\ProductPolicy;
use App\Policies\GenderPolicy;
use App\Policies\HeelPolicy;
use App\Policies\ImagePolicy;
use App\Policies\MaterialPolicy;
use App\Policies\PricePolicy;
use App\Policies\SizePolicy;
use App\Policies\TagPolicy;
use App\Policies\TypePolicy;
use App\Policies\QuestionPolicy;
use App\Policies\WishlistPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Product::class => ProductPolicy::class,
        Color::class => ColorPolicy::class,
        Gender::class => GenderPolicy::class,
        Heel::class => HeelPolicy::class,
        Image::class => ImagePolicy::class,
        Material::class => MaterialPolicy::class,
        Price::class => PricePolicy::class,
        Size::class => SizePolicy::class,
        Tag::class => TagPolicy::class,
        Type::class => TypePolicy::class,
        Question::class => QuestionPolicy::class,
        Wishlist::class => WishlistPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
