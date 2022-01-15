<table>
    <thead>

    <tr>
        <th>#</th>
        @foreach($heading as $title)
            <th>{{$title}}</th>
        @endforeach
    </tr>


    </thead>
    <tbody>
    @foreach($table as $row)
        <tr>
            @foreach($row as $key=>$col)
                @if ($key==0)
                    <td>{{\Carbon\Carbon::parse($col->day)->isoFormat('DD-MM-YYYY')}}</td>
                @endif
                <td>
                    @if (!$col->is_installed)
                        <span>  Не выставлялся</span>
                    @else
                        <p>Начало работы с {{\Carbon\Carbon::parse($col->start_at)->isoFormat('HH-mm')}}</p>
                        <p>Конец работы в {{\Carbon\Carbon::parse($col->end_at)->isoFormat('HH-mm')}}</p>
                        <p>Адресс: {{$col->address}}</p>
                    @endif
                </td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>
