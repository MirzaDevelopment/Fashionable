<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use App\Models\Product;
use App\Models\Price;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProductDiscountMail extends Mailable
{
    use Queueable, SerializesModels;
    public $price;
    public $size;
    /**
     * Create a new message instance.
     */
    public function __construct(public Product $product)
    {
        $this->size = $product->sizesVariant()->get();
        $this->price=Price::where("product_id",$product ->id)->first();
       
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Obaviještavamo Vas da je proizvod na vašoj listi želja trenutno na popustu!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.productdiscount',
             with: [
                'productName' => $this->product->product_name,
                'productMaterials'=>$this->product->materials,
                'productSizes'=>$this->size,
                'price' => $this->price->price,
                'discount' => $this->price->discount

            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
