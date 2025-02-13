<x-guest-layout>
  <h1>All Products</h1>

  @forelse ($products as $product)
    <h5>{{ $product->name }}</h5>
    <h6>{{ $product->type }}</h6>
    <span>{{ $product->price }}</span>
  @empty
    <p>No products found.</p>
  @endforelse
</x-guest-layout>
