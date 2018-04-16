<div class="container">
    <div class="row">
        @if(Session::has('message'))
            <div class="alert alert-success col-12">
                {{  Session::get('message') }}

                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger col-12">

                {{ implode('', $errors->all(':message')) }}

                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

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
    </div>

</div>