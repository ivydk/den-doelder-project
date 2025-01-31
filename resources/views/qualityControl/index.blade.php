@extends('layouts.master')

@section('content')
    <section class="section">

        <img src="/img/svg/back-arrow.svg" onclick="history.back();" width="35" height="35">

        <div class="container">
            <h1 class="title has-text-centered">{{__("Order")}} {{ $order->ordernumber }}</h1>
        </div>

        <table class="table is-bordered">
            <thead>
            <tr>
                <th><abbr title="time">{{__("Time")}}</abbr></th>
                <th><abbr title="name-pallet">{{__("Pallet name")}}</abbr></th>
                <th><abbr title="def-nr">def nr</abbr></th>
                <th><abbr title="extra-info">extra info</abbr></th>
                <th><abbr title="action">{{__("Action")}}</abbr></th>
                <th><abbr title="deviation">{{__("Deviation")}}</abbr></th>
                <th><abbr title="edit-button"></abbr></th>
            </tr>
            </thead>
            <tbody>
            @foreach($qualities as $quality)
                <tr>
                    <td>{{ $quality->time }}</td>
                    <td>{{ $quality->name_pallet }}</td>
                    <td>{{ $quality->def_nr }}</td>
                    <td>{{ $quality->extra_info}}</td>
                    <td>{{ $quality->action}}</td>
                    <td>{{ $quality->deviation}}</td>
                    <td>
                        <a href="{{route('qualityControl.edit', $quality)}}">
                            <button class="btn btn-default" type="button">{{__("Edit")}}</button>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>


    </section>

@endsection
