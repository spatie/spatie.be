<style>
    @media print{
        .noprint{
            display:none;
        }
    }
</style>
<div class="noprint reverse-impersonate-container" data-position="0" style="
     position: fixed;
     padding: 15px 20px 15px 15px;
     min-width: 160px;
     top: 25%;
     right: -5px;
     color: black;
     background-color: #fff;
    -webkit-box-shadow: 0 2px 4px 0 rgba(0, 0, 0, .05);
    box-shadow: 0 2px 4px 0 rgba(0, 0, 0, .05);
    border-radius: .5rem;
    text-align: center;
    z-index: 9999;
    user-select: none;
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    "
>
    <p>
        Impersonating as {{ $impersonatingAsUser->email }}
    </p>

    <a href="{{ route('stop-impersonation') }}" style="text-decoration:underline;color: black;font-weight: bold">
        Stop impersonating
    </a>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        function reverseImpersonateContainerOnDblclick(event) {
            var attribute = 'data-position',
                position = !parseInt(event.target.getAttribute(attribute));

            event.target.setAttribute(attribute, +position);
            event.target.style.top = position
                ? '75%'
                : '25%';
        }

        var shields = document.getElementsByClassName('reverse-impersonate-container');

        for (var i = 0; i < shields.length; i++) {
            shields[i].addEventListener('dblclick', reverseImpersonateContainerOnDblclick)
        }
    });
</script>
