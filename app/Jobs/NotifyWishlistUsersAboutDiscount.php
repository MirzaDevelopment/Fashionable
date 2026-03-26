<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Models\Product;
use App\Models\Wishlist;
use App\Mail\ProductDiscountMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;

class NotifyWishlistUsersAboutDiscount implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public int $productId;

    /**
     * Create a new job instance.
     */
    public function __construct($productId)
    {
       $this->productId = $productId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $product = Product::find($this->productId);
        $users = $product->users;
        if($users != null){
            foreach ($users as $user) {
           if($user->pivot->notified_of_discount!=true){
            Mail::to($user->email)
            ->queue(new ProductDiscountMail($product)); //ovo popraviti
            $user->products()->wherePivot('user_id', $user->id)->updateExistingPivot($product->id, ['notified_of_discount' =>   true]);
           }
             }

        } else return;
    }
}
