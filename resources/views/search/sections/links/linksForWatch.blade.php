<div class="container">
    <table class="table table-dark" style="background-color: white">
        <tr align="center">
            <td>
                Watch in playster this {{ $mediaTypeTitle }} - <a
                        href="{{ config('main.links.playster.prod') }}{{ $mediaTypeTitle }}/{{ $info['id']}}/{{$info['title']}}"
                        target="_blank"> {{ $info['title'] }}</a>

            </td>
        </tr>
        <tr align="center">
            <td>
                Watch in QA playster this {{ $mediaTypeTitle }} - <a
                        href="{{ config('main.links.playster.qa') }}{{ $mediaTypeTitle }}/{{ $info['id']}}/{{$info['title']}}"
                        target="_blank">{{ $info['title'] }}</a>
            </td>
        </tr>
    </table>
</div>
