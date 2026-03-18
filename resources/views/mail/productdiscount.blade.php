
<h2>Naziv proizvoda:</h2> 
<p>{{$productName}}</p>
<h2>Materijal:</h2>
@foreach($productMaterials as $material)
<p>{{$material->material}}</p>
@endforeach
@php
$uniqueSizes=collect($productSizes)->unique('size')
@endphp
<h2>Dostupne veličine:</h2>
@foreach($uniqueSizes as $sizes)
<p>{{$sizes->size}}</p>
@endforeach
<h2>Trenutni popust:</h2> 
<p>-{{$discount}}%</p>
<h2>Trenutna cijena (nakon popusta)</h2>
<p>{{$price->price}}$</p>