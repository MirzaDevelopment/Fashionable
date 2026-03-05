<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;

class NotifyWishlistUsersAboutDiscount implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $product;

    /**
     * Create a new job instance.
     */
    public function __construct($newProduct)
    {
        $this->product = $newProduct;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $users = $this->product->users;
            foreach ($users as $user) {
            Mail::to($user->email)
            ->queue(new ProductDiscountMail($this->product)); //ovo popraviti
        }
    }
}
