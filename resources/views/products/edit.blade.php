<x-guest-layout>
  <h1>Edit Product</h1>

  <form method="POST" action="{{ route('products.update', $product->id) }}">
    @csrf
    @method('PUT')

    <!-- Name -->
    <div>
      <x-input-label for="name" :value="__('Name')" />
      <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $product->name)" required
        autofocus autocomplete="name" />
      <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <!-- Type -->
    <div>
      <x-input-label for="type" :value="__('Type')" />
      <x-text-input id="type" class="block mt-1 w-full" type="text" name="type" :value="old('type', $product->type)" required
        autofocus autocomplete="type" />
      <x-input-error :messages="$errors->get('type')" class="mt-2" />
    </div>

    <!-- Price -->
    <div>
      <x-input-label for="price" :value="__('Price')" />
      <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" :value="old('price', $product->price)" required
        autofocus autocomplete="price" />
      <x-input-error :messages="$errors->get('price')" class="mt-2" />
    </div>

    <x-primary-button class="ms-3">
      {{ __('Save') }}
    </x-primary-button>
    </div>
  </form>
</x-guest-layout>
