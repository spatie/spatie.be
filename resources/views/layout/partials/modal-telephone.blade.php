<div id="tel" class="modal" onclick="history.back()">
    <div class="m-8 text-center bg-white p-8 z-20 shadow-lg | md:p-16">
        <a href="tel:+3232925679">
            <p class="font-sans-bold whitespace-no-wrap" style="font-size: 9vw;">+32 3 292 56 79</p>
        </a>
        <p class="md:absolute pin-l pin-r pin-b md:text-lg md:p-8">
            @if(is_office_open())
                <span class="text-green links-underline links-green"><a href="tel:+3232925679">Click to call us</a>
            @else
                <span class="text-pink-dark links-underline links-pink">Our office is closed now, <a href="{{ mailto(
'I\'d like to have a chat!',
'Tell us how we can help you:
- Call you back
- Arrange a meeting
- …
'
) }}">email us instead</a></span>
            @endif
        </p>
    </div>
</div>
