@push('scripts')
<script src="https://player.vimeo.com/api/player.js"></script>
<script>
    var vimeoWrapper = document.querySelector('#vimeo');
    var player = new Vimeo.Player(document.querySelector('#player'));

    if (localStorage.getItem('spatie.videos.rate')) {
        player.setPlaybackRate(localStorage.getItem('spatie.videos.rate'))
    }

    // Automatically send the user to the next video after completion.
    player.on('ended', function() {
        let completeButton = document.querySelector('.complete');

        if (completeButton) {
            completeButton.click();
        }

        // Don't the next link if there is none
        @if ($nextLesson)
            location.href = '{{ route('courses.show', [$nextLesson->series, $nextLesson]) }}';
        @endif
    });

    // Remember the user's PlaybackRate.
    player.on('playbackratechange', function () {
        player.getPlaybackRate().then(function (rate) {
            localStorage.setItem('spatie.videos.rate', rate)
        })
    })
</script>
@endpush
