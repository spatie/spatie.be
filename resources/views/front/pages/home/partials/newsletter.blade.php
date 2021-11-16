<section id="newsletter" class="z-10 mt-32">
    <div class="wrap">
        <div class="card gradient gradient-pink text-white">
            <div class="wrap-card md:gap-16 grid md:grid-cols-2 md:items-center">
                <div>
                    <h2 class="title-xl md:text-right">
                        Subscribe for <br>Updates
                    </h2>
                    
                </div>
                <div>
                    <form class="flex" method="POST" action="https://spatie.be/mailcoach/subscribe/4af46b59-3784-41a5-9272-6da31afa3a02">
                        <input name="email" class="flex-grow form-input h-12" placeholder="Your Email">
                        <button class="-ml-1 cursor-pointer
bg-pink-dark bg-opacity-75 hover:bg-opacity-100 rounded-sm
border-2 border-transparent
justify-center flex items-center
px-4 min-h-12 text-xl shadow-lg
font-sans-bold text-white
transition-bg duration-300
focus:outline-none focus:border-blue-light whitespace-no-wrap">Subscribe</button>
                    </form>
                    <p class="mt-2">
                        Get the latest news on Spatie products and promotions. <br>
                        No spam, just a few emails per year.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

@include('layout.partials.modal-match')
