@if(app()->environment('production'))
    <script type="text/javascript">
        var _paq = _paq || [];

        _paq.push(['trackPageView']);
        _paq.push(['enableLinkTracking']);
        (function() {
            var u="https://analytics.spatie.be/";
            _paq.push(['setTrackerUrl', u+'piwik.php']);
            _paq.push(['setSiteId', '1']);
            var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
            g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
        })();

        @if(session()->has('completed_goal_id'))
            _paq.push(['trackGoal', {{session()->get('completed_goal_id')}}, {{ session()->get('completed_goal_earnings', 0) }}]);
        @endif
    </script>
@endif
