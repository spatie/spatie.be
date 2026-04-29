<div id="tel" class="modal" onclick="history.back()">
    <div class="font-pt m-8 text-center text-oss-green-pale p-8 z-20 md:p-16">
        <a href="tel:+3232925679">
            <p class="text-[9vw] font-pt font-bold whitespace-nowrap">+32 3 292 56 79</p>
        </a>
        <p class="md:absolute left-0 right-0 bottom-0 md:text-lg md:p-8">
            @if(is_office_open())
                <span class="text-green links-underline links-green"><a href="tel:+3232925679">Click to call us</a></span>
            @else
                <span class="text-pink-lighter links-underline links-pink">Our office is closed now, <a href="{{ mailto(
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
