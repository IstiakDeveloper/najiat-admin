<div>
    <div class="flex flex-col justify-center md:flex-row">
        <!-- Product Image -->
        <div class="md:mr-32  md:max-h-full">
            <a href="#" wire:click.prevent="showPdf">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="object-cover" width="300px">
            </a>
        </div>

        <!-- Product Information -->
        <div class="flex-1 max-w-2xl py-8">
            <!-- Product Details -->
            <div>
                <h2 class="text-2xl lg:text-3xl font-semibold mb-8">{{ $product->name }}</h2>
                <p class="text-gray-600 mb-8">{{ $product->description }}</p>
                <div class="mt-4">
                    <p class="text-gray-700 mb-4"><strong>Author:</strong> {{ $product->author }}</p>
                    <p class="text-gray-700 mb-4"><strong>Category:</strong> {{ $product->category->name }}</p>
                    <p class="text-gray-700 mb-4"><strong>Regular Price:</strong> ${{ $product->regular_price }}</p>
                    <p class="text-gray-700 mb-4"><strong>Sale Price:</strong> ${{ $product->sale_price }}</p>
                </div>
            </div>

            <!-- Order Now Button -->
            <div class="mt-6">
                <button wire:click="toggleModal({{ $product->id }}, 2)" class="bg-purple-500 text-white px-4 py-2 rounded-md mr-4 mt-4 transition duration-300 ease-in-out transform hover:scale-105">
                    <i class="fas fa-shopping-bag"></i> Order Now
                </button>
            </div>
        </div>

        <input type="checkbox" id="orderNowCheckbox" class="hidden" wire:model="showOrderForm" wire:click="closeOutsideModal">

        <!-- Modal component for the home page -->
        @if($showOrderForm)
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center">
                <div class="bg-white p-6 rounded-md relative">
                    <button class="absolute top-2 right-2 text-gray-500 hover:text-red-500" wire:click="closeOutsideModal">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>

                    <livewire:show-order-form :product="$selectedProduct" :key="$selectedProduct->id" />
                </div>
            </div>
        @endif
    </div>

    <hr class="border-t my-6">

    <div class="mt-8">
        <h2 class="text-2xl font-semibold mb-4">Related Books</h2>
        <div id="related-products" class="glide">
            <div class="glide__track" data-glide-el="track">
                <ul class="glide__slides">
                    @foreach($relatedProducts as $relatedProduct)
                        <li class="glide__slide">
                            <!-- Related Product Card -->
                            <div class="max-w-sm rounded overflow-hidden shadow-md">
                                <img src="{{ asset('storage/' . $relatedProduct->image) }}" alt="{{ $relatedProduct->name }}" class="w-full h-48 object-cover">
                                <div class="px-6 py-4">
                                    <h2 class="text-xl font-semibold text-gray-800">{{ $relatedProduct->name }}</h2>
                                    <p class="text-gray-600">{{ $relatedProduct->category->name }}</p>

                                    <!-- Price Details -->
                                    <div class="mt-2 relative">
                                        @if ($relatedProduct->sale_price < $relatedProduct->regular_price)
                                            <p class="text-gray-700 line-through">Regular Price: ${{ $relatedProduct->regular_price }}</p>
                                            <p class="text-red-500 font-semibold">Sale Price: ${{ $relatedProduct->sale_price }}</p>
                                        @else
                                            <p class="text-gray-700">Price: ${{ $relatedProduct->regular_price }}</p>
                                        @endif
                                    </div>
                                    <button class="bg-purple-500 text-white px-4 py-2 rounded-md" wire:click="showProduct({{ $relatedProduct->id }})">View Product</button>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
        document.addEventListener('DOMContentLoaded', function () {
            var relatedProductsGlide = new Glide('#related-products', {
                type: 'carousel',
                perView: 4, // Adjust the number of visible related products as needed
                breakpoints: {
                    768: {
                        perView: 1, // Adjust for smaller screens
                    }
                },
                autoplay: 5000, // Adjust the autoplay interval as needed
                hoverpause: true, // Pause autoplay on hover
            });

            relatedProductsGlide.mount();
        });
    </script>



