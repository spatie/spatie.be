@if (flash()->message)
    <div class="flash-wrap">
        <div class="flash flash-{{ flash()->class }}">
            {{ flash()->message }} <button class="ml-4 opacity-50" onClick="this.parentElement.classList.add('flash-hidden');">&times;</button>
        </div>
    </div>

    <script>
        setTimeout(function(){
            document.querySelector(".flash").classList.add("flash-hidden");
        }, 5000);
    </script>
@endif