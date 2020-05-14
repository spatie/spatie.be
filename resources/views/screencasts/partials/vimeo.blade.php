@push('scripts')
<script src="https://player.vimeo.com/api/player.js"></script>
<script>
    var iframe = document.querySelector('iframe');
    var player = new Vimeo.Player(iframe);
    if (localStorage.getItem('spatie.screencasts.rate')) {
        player.setPlaybackRate(localStorage.getItem('spatie.screencasts.rate'))
    }
    // Automatically send the user to the next video after completion.
    player.on('ended', function() {
        // Don't the next link if there is none
        if (@json(! $nextScreencast)) return;
        location.href = '{{ route('screencasts.show', [$nextScreencast->series, $nextScreencast]) }}';
    });

    // Remember the user's PlaybackRate.
    player.on('playbackratechange', function () {
        player.getPlaybackRate().then(function (rate) {
            localStorage.setItem('spatie.screencasts.rate', rate)
        })
    })
</script>
@endpush
