<tr>
    <button type="button" class="btn btn-warning" data-toggle="collapse" data-target="#music">Show tracks in album
    </button>

    <div id="music" class="collapse">
        <ul class="list-group">
            @foreach($tracks as $track)
                <li class="list-group-item">
                    <a href="{{ route('reports.track.index', [
                                'id' => $track['id']]) }}"
                       style="color: #b6a338; text-decoration: none; font-weight: bold;"
                       class="list-group-item list-group-item-action" title="Click to track for more info">
                        <span style="color: #761c19">[id]</span>- {{ $track['id'] }}
                        |&nbsp;<span style="color: #761c19">[Title]</span>- {{ $track['title'] }}
                        |&nbsp;<span style="color: #761c19">[Date Added]</span> - {{ $track['date_added'] }}
                        |&nbsp;<span style="color: #761c19">[Status]</span> - {{ $track['status'] }}
                        | <span style="color: #761c19">[In 7digital]</span> - {{ checkHeaders($track['download_url']) }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
    <td>artist Name</td>
    <td></td>
    <td>{{ $artistName }}</td>
</tr>