@php
$makeup = $view['makeup'] ?? '';
$keys = array_keys($view['items']);
$headLabels = array_values($view['items']);
@endphp
<table class="table {{$makeup}}">
    <thead>
        <tr>
            @foreach ($headLabels as $label)
                <th scope="col">{{$label}}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $item)
            <tr>
                @foreach ($keys as $key)
                    <td>{{ $item[$key] ?? '' }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>