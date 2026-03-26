<table width="100%" cellpadding="0" cellspacing="0" style="font-family: Arial, sans-serif; background-color: #f5f5f5; padding: 20px;">
    <tr>
        <td align="center">
            <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; padding: 20px;">
                
                <!-- Images Grid -->
                <tr>
                    <td align="center">
                        <table cellpadding="0" cellspacing="0">
                            <tr>
                                @foreach ($imagePath as $index => $path)
                                    <td align="center" style="padding: 5px;">
                                        <img src="{{{ $message->embed($path) }}}" 
                                             width="160" 
                                             style="display: block; border-radius: 6px;" 
                                             alt="product_image">
                                    </td>

                                    @if(($index + 1) % 3 == 0)
                                        </tr><tr>
                                    @endif
                                @endforeach
                            </tr>
                        </table>
                    </td>
                </tr>

                <!-- Title -->
                <tr>
                    <td style="padding-top: 10px;">
                        <h2 style="margin: 0; color: #333;">Naziv proizvoda</h2>
                        <p style="margin: 5px 0 15px; font-size: 16px; color: #555;">
                            {{$productName}}
                        </p>
                    </td>
                </tr>

                <!-- Materials -->
                <tr>
                    <td>
                        <h3 style="margin: 0; color: #333;">Materijal</h3>
                        @foreach($productMaterials as $material)
                            <p style="margin: 5px 0; color: #555;">
                                {{$material->material}}
                            </p>
                        @endforeach
                    </td>
                </tr>

                <!-- Sizes -->
                @php
                    $uniqueSizes = collect($productSizes)->unique('size');
                @endphp
                <tr>
                    <td style="padding-top: 10px;">
                        <h3 style="margin: 0; color: #333;">Dostupne veličine</h3>
                        @foreach($uniqueSizes as $sizes)
                            <span style="display: inline-block; background-color: #eee; padding: 5px 10px; margin: 5px 5px 0 0; border-radius: 4px; font-size: 14px;">
                                {{$sizes->size}}
                            </span>
                        @endforeach
                    </td>
                </tr>

                <!-- Discount -->
                <tr>
                    <td style="padding-top: 15px;">
                        <h3 style="margin: 0; color: #333;">Trenutni popust</h3>
                        <p style="margin: 5px 0; font-size: 18px; color: #e53935; font-weight: bold;">
                            -{{$discount}}%
                        </p>
                    </td>
                </tr>

                <!-- Price -->
                <tr>
                    <td style="padding-top: 10px;">
                        <h3 style="margin: 0; color: #333;">Cijena nakon popusta</h3>
                        <p style="margin: 5px 0; font-size: 20px; color: #2e7d32; font-weight: bold;">
                            ${{$price->price}}
                        </p>
                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td style="padding-top: 20px; text-align: center; font-size: 12px; color: #999;">
                        Vaša lista želja je dostupna na /*work in progress*/
                        Dobijate ovu notifikaciju jer ste pratili ovaj proizvod.
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>