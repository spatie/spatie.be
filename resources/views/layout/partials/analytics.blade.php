@if(app()->environment('production'))
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-131225353-2"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-131225353-2');

        @if(session()->has('completed_goal_id'))
            {{-- TODO --}}
            {{--_paq.push(['trackGoal', {{session()->get('completed_goal_id')}}, {{ session()->get('completed_goal_earnings', 0) }}]);--}}
        @endif
    </script>
@endif
