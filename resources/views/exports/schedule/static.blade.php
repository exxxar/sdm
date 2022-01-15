<table>
    <thead>

    <tr>
        <th>#</th>
        <th>Название рубежа</th>
        <th>Устройства</th>
        <th>Дата установки</th>
        <th>Дата удаления</th>
    </tr>


    </thead>
    <tbody>
    @foreach($table as $row_index=>$row)
        <tr>
            <td>{{$row_index+1}}</td>

                <th>{{$row->title}}</th>
                <th>
                    @isset ($row->devices)
                        @foreach($row->devices as $device)
                            <p>[#{{$device->id}}] {{$device->serial??"Не указано"}}</p>
                        @endforeach
                    @endisset
                </th>
                <th>
                    @isset($row->install_date)
                        {{\Carbon\Carbon::parse($row->install_date)->isoFormat('DD-MM-YYYY HH-mm')}}
                    @else
                        {{\Carbon\Carbon::parse($row->created_at)->isoFormat('DD-MM-YYYY HH-mm')}}
                    @endisset
                </th>
                <th>
                    @isset($row->uninstall_date)
                        {{\Carbon\Carbon::parse($row->uninstall_date)->isoFormat('DD-MM-YYYY HH-mm')}}
                    @else
                        не задана
                    @endisset
                </th>


        </tr>
    @endforeach
    </tbody>
</table>
