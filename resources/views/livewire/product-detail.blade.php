<div class="flex items-center justify-center h-screen">
    <!-- Product Image -->
    <div class="mr-8">
        <a href="#" wire:click.prevent="showPdf">
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="250" height="375" class="object-cover rounded-md">
        </a>
    </div>

    <!-- Product Information -->
    <div class="max-w-xl">
        <!-- Product Details -->
        <div>
            <h2 class="text-2xl lg:text-3xl font-semibold mb-2">{{ $product->name }}</h2>
            <p class="text-gray-600">{{ $product->description }}</p>
            <!-- Additional details -->
            <div class="mt-4">
                <p class="text-gray-700"><strong>Author:</strong> {{ $product->author }}</p>
                <p class="text-gray-700"><strong>Category:</strong> {{ $product->category->name }}</p>
                <p class="text-gray-700"><strong>Regular Price:</strong> ${{ $product->regular_price }}</p>
                <p class="text-gray-700"><strong>Sale Price:</strong> ${{ $product->sale_price }}</p>
            </div>
        </div>

        <!-- Order Now Button -->
        <div class="mt-6">
            <button class="bg-blue-500 text-white px-6 py-3 rounded-md" wire:click="orderNow">Order Now</button>
        </div>
    </div>

    <!-- PDF Modal -->
    <div id="pdfModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white p-8 w-full max-w-xl mx-auto rounded-md shadow-lg relative">
            <button id="closePdfModal" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
            <!-- Display the PDF using the <iframe> tag -->
            <iframe src="{{ $pdfUrl }}" width="100%" height="600px"></iframe>

            <!-- Close button -->
            <button id="closePdfButton" class="bg-red-500 text-white px-4 py-2 rounded-md mt-4">
                Close PDF
            </button>
        </div>
    </div>

    <script defer>
        // JavaScript for closing the PDF modal
        document.getElementById('closePdfModal').addEventListener('click', function () {
            document.getElementById('pdfModal').classList.add('hidden');
        });

        document.getElementById('closePdfButton').addEventListener('click', function () {
            document.getElementById('pdfModal').classList.add('hidden');
        });
    </script>
</div>
