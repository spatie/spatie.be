@push('scripts')
<script src="https://player.vimeo.com/api/player.js"></script>
<script>
    var iframe = document.querySelector('iframe');
    var player = new Vimeo.Player(iframe);
    if (localStorage.getItem('spatie.videos.rate')) {
        player.setPlaybackRate(localStorage.getItem('spatie.videos.rate'))
    }
    // Automatically send the user to the next video after completion.
    player.on('ended', function() {
        // Don't the next link if there is none
        if (@json(! $nextVideo)) return;
        location.href = '{{ route('videos.show', [$nextVideo->series, $nextVideo]) }}';
    });

    // Remember the user's PlaybackRate.
    player.on('playbackratechange', function () {
        player.getPlaybackRate().then(function (rate) {
            localStorage.setItem('spatie.videos.rate', rate)
        })
    })
</script>
@endpush
