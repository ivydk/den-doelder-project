@extends('layouts.master')

@section('content')
    <section class="section">

        <form method="get" action="{{ route('backlog.index') }}">

            <div>
                <select id="txtSearch" name="category">
                    <option
                        value="">
                       {{__("All")}}
                    </option>
                    <option
                        value="mechanical" <?php if (app('request')->input('category') === 'mechanical') echo "selected";?>>
                       {{__("Mechanical")}}
                    </option>
                    <option
                        value="technical" <?php if (app('request')->input('category') === 'technical') echo "selected";?>>
                  {{__("Technical")}}
                    </option>
                </select>
                <select id="txtSearch" name="cape">
                    <option
                        value="">
                       {{__("All")}}
                    </option>
                    <option
                        value="1" <?php if (app('request')->input('cape') === '1') echo "selected";?>>
                        1
                    </option>
                    <option
                        value="2" <?php if (app('request')->input('cape') === '2') echo "selected";?>>
                        2
                    </option>
                    <option
                        value="5" <?php if (app('request')->input('cape') === '5') echo "selected";?>>
                        5
                    </option>
                </select>

            <input type="submit" value="{{__("Filter")}}" class="btn btn-default"/>
            </div>
        </form>

        <table class="table">
            <thead>
            <tr>
                <th><abbr title="order_id">{{__("Order")}}</abbr></th>
                <th><abbr title="production_line">Cape</abbr></th>
                <th><abbr title="time">{{__("Time")}}</abbr></th>
                <th><abbr title="date">{{__("Date")}}</abbr></th>
                <th><abbr title="category">{{__("Category")}}</abbr></th>
                <th><abbr title="description">{{__("Description")}}</abbr></th>
                <th><abbr title="edit-button"></abbr></th>
                <th><abbr title="delete-buttons"></abbr></th>
            </tr>
            </thead>
            <tbody>
            @foreach($backlogs as $backlog)
                <tr>
                    <th>{{ $backlog->order->ordernumber}}</th>
                    {{-- TODO: nette oplossing --}}
                    <th> @if($backlog->order->production_line_id === 3) 5
                        @else {{ $backlog->order->production_line_id }}
                        @endif</th>
                    <td>{{ $backlog->time }}</td>
                    <td>{{ $backlog->date }}</td>
                    <td>@if($backlog->category === 'technical')
                            T
                        @else
                            M
                        @endif
                    </td>
                    <td>{{ $backlog->description }}</td>
                    <td>
                        <a href="{{route('backlog.edit', $backlog)}}">
                            <button class="btn btn-default" type="button">{{__("Edit")}}</button>
                        </a>
                    </td>
                    <td>
                        <form method="POST" action="{{route('backlog.destroy', $backlog)}}">
                            @csrf
                            @method('DELETE')
                            {{-- TODO: change confirm message --}}
                            <button type="submit" class="btn btn-danger"
                                    onclick="return confirm({{__("Are you sure you want to delete this error?")}})">
                                {{__("Delete")}}
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </section>

@endsection
