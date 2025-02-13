<x-guest-layout>
  <h1>All Products</h1>

  @if (auth()->user()?->is_admin)
    <a class="{{ route('products.create') }}">Create Product</a>
  @endif

  @forelse ($products as $product)
    <h5>{{ $product->name }}</h5>
    <h6>{{ $product->type }}</h6>
    <span>{{ $product->price }}</span>

    @auth
      <button>Buy</button>
    @endauth
  @empty
    <p>No products found.</p>
  @endforelse
</x-guest-layout>
