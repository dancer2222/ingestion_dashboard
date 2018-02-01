@if(Session::has('message'))
    <div class="alert alert-danger">
        {{  Session::get('message') }}
    </div>
@endif
@if ($errors->any())
    <div class="alert alert-danger">

    {{ implode('', $errors->all(':message')) }}

    </div>
@endif

@if(isset($messages))
    <div class="container col-xs-8">
        <h3 style="color: red">Failed items</h3>
        <table class="table table-danger" border="2px">
            <tr>
                @foreach($messages[0] as $item => $a)
                    <th style="background-color: #2ca02c">
                        {{ $item }}
                    </th>
                @endforeach
            </tr>
                @foreach($messages as $message)
                    <tr>
                        @foreach($message as $value)
                            <td>
                                <p style="font-size: 12px">{{ $value }}</p>
                            </td>
                        @endforeach
                    </tr>
                @endforeach
        </table>
    </div>
@endif