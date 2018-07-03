<div class="container">

    <a href="" data-toggle="collapse"
       data-target="#failedItem" class="btn btn-primary btn-lg btn-block">
        Failed Items
    </a>
    <br>

    <div id="failedItem" class="collapse text-left">
        <div class="row">
            <div class="container col-xs-8">
                <table class="display nowrap table table-hover table-striped table-bordered dataTable" border="2px">
                    <tr>
                        @foreach($messages[0] as $item => $a)
                            <th>
                                {{ $item }}
                            </th>
                        @endforeach
                    </tr>
                    @foreach($messages as $message)
                        <tr>
                            @foreach($message as $value)
                                <td>
                                    @if($message['status'] === 'active')
                                        <p style="color: red">{{ $value }}</p>
                                    @else
                                        <p style="color: green">{{ $value }}</p>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>