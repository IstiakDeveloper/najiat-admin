<div>


    @if($products && $products->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @foreach ($products as $product)
            <div class="group relative">
                <a href="{{ route('products.show', $product->id) }}" class="block relative">
                    <div class="bg-white p-4 rounded-lg text-center group-hover:shadow-lg transition duration-300 ease-in-out">
                        <!-- Product Image -->
                        <div class="flex items-center justify-center relative mb-4">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="192" height="254" class="object-cover rounded-md">

                            <!-- Discount Badge -->
                            @if ($product->sale_price < $product->regular_price)
                                <div class="absolute top-0 right-0 bg-green-500 text-white p-2 rounded-full">
                                    <span style="line-height: 15px; font-size: 14px; padding: 5px; display:block"> {{ round((($product->regular_price - $product->sale_price) / $product->regular_price) * 100) }}%<br>Off</span>
                                </div>
                            @endif
                        </div>

                        <!-- Product Details -->
                        <h2 class="text-xl font-semibold text-gray-800">{{ $product->name }}</h2>
                        <p class="text-blue-500 font-semibold">{{ $product->author }}</p>
                        <p class="text-gray-600">{{ $product->category->name }}</p>

                        <!-- Price Details -->
                        <div class="mt-2 relative">
                            @if ($product->sale_price < $product->regular_price)
                                <p class="text-gray-700 line-through">Regular Price: ${{ $product->regular_price }}</p>
                                <p class="text-red-500 font-semibold">Sale Price: ${{ $product->sale_price }}</p>
                            @else
                                <p class="text-gray-700">Price: ${{ $product->regular_price }}</p>
                            @endif
                        </div>
                    </div>
                </a>

                <!-- Add to Cart and Wish List Buttons -->
                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 bg-blue-200 transition-opacity duration-300">
                    <a href="#" class="bg-blue-500 text-white px-4 py-2 rounded-md mr-4" onclick="event.stopPropagation();">
                        <i class="fas fa-shopping-cart"></i>
                    </a>
                    <a href="#" class="text-gray-500 hover:text-red-500" onclick="event.stopPropagation();">
                        <i class="fas fa-heart"></i>
                    </a>
                    <a href="{{ route('product.detail', $product->id) }}" class="absolute bottom-0 p-4 bg-white w-full text-center text-gray-800 hover:bg-gray-100">
                        View Details
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <p>No products available in this category.</p>
    @endif

</div>
