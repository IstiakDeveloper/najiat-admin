<div>
    <div>

        <!-- Product Section -->
        <section class="mb-8">
            <h2 class="text-3xl font-semibold mb-4">Featured Products</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-8">
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
                        <button class="bg-blue-500 text-white px-4 py-2 rounded-md mr-4" wire:click="addToCart({{ $product->id }})"><i class="fas fa-shopping-cart"></i></button>

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
        </section>


        <!-- Category Section -->
        <section class="mb-8">
            <h2 class="text-3xl font-semibold mb-4">Categories</h2>
            <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-8">
                @foreach ($categories as $category)
                    <div class="group relative hover:opacity-80 transition-all ease-in-out">
                        <a href="{{ route('category.show', $category->id) }}" class="block">
                            <div class="bg-white p-4 rounded-lg text-center group-hover:shadow-lg transition duration-300 ease-in-out">
                                <div class="flex items-center justify-center">
                                    <img class="w-16 h-16 mb-2" src="{{ asset('storage/' . $category->image)}}" alt="{{$category->name}}">
                                </div>
                                <h2 class="text-xl font-semibold text-gray-800">{{ $category->name }}</h2>
                                <!-- Add more category details as needed -->
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </section>


        <!-- Blog Section -->
        <section class="mb-8">
            <h2 class="text-3xl font-semibold mb-4">Latest Blogs</h2>
            <!-- Add your blog content here -->
        </section>

        <!-- More Section -->
        <section>
            <h2 class="text-3xl font-semibold mb-4">Explore More</h2>
            <!-- Add more content sections as needed -->
        </section>
    </div>
</div>
