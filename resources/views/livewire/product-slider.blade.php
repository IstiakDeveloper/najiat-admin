<section class="hero-slider bg-purple-100 text-black max-h-96 rounded-3xl overflow-hidden relative">
    <div class="container mx-auto">
        <div id="slider" class="glide">
            <div class="glide__track" data-glide-el="track">
                <ul class="glide__slides">
                    <!-- Your slides go here -->
                    <li class="glide__slide">
                        <div class="flex items-center justify-center flex-col md:flex-row py-4 md:py-0 lg:py-0">
                            <div class="md:w-1/2 text-center md:text-left md:pr-16 md:p-16">
                                <h1 class="text-xl md:text-4xl lg:text-4xl font-bold mb-4">Discover Your Next Favorite Book</h1>
                                <p class="text-md mb-8">Explore a curated collection of books that will captivate your imagination.</p>
                                <a href="{{route('books')}}" class="bg-purple-500 text-white px-6 py-3 mb-4 rounded-full hover:bg-purple-700 transition duration-300 ease-in-out">Browse Books</a>
                            </div>
                            <div class="md:w-1/2 mt-8 md:mt-0 p-4 hidden md:block">
                                <img src="{{asset('hero-img.png')}}" alt="Bookshop Hero Image" class="w-full rounded-lg" style="height: 350px;">
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Include Glider.js JS -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var glide = new Glide('#slider', {
            type: 'carousel',
            perView: 1,
            autoplay: 5000, // Adjust the autoplay interval as needed
            animationDuration: 800, // Adjust the animation duration
        });

        glide.mount();
    });
</script>
