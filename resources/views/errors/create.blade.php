@extends('layouts.master')

@section('content')
    <section class="section">
        <div class="container">
            {{-- TODO: make ordernumber dynamic --}}

            <h1>Order {{ app('request')->input('ordernumber') }} </h1>
            <form method="POST" action="{{route('error.store')}}">
                @csrf

                <label for="order_id"></label>
                <div class="label">
                    <div class="control has-icons-left has-icons-right">
                        <input
                                class="input @error('order_id') is-danger @enderror"
                                type="hidden"
                                id="order_id"
                                name="order_id"
                                value="{{ app('request')->input('ordernumber') }}"
                    </div>
                </div>

                <label for="time">Time:</label><br>
                <div class="label">
                    <div class="control has-icons-left has-icons-right">
                        <input
                                class="input @error('time') is-danger @enderror"
                                type="time"
                                id="time"
                                name="time"
                                value="{{$errors->any() ? old('time') : ''}}"
                        >
                    </div>
                    <br>
                    @error('time')
                    <p class="help is-danger">This is a required field</p>
                    @enderror
                </div>

                <label for="date">Date:</label><br>
                <div class="label">
                    <div class="control has-icons-left has-icons-right">
                        <input
                                class="input @error('date') is-danger @enderror"
                                type="date"
                                id="date"
                                name="date"
                                value="{{$errors->any() ? old('date') : ''}}"
                        //required
                    </div>
                    <br>
                    @error('date')
                    <p class="help is-danger">This is a required field</p>
                    @enderror
                </div>
                <br>

                <label for="category">Error category:</label><br>
                <div class="label">
                    <div class="select">
                        <select
                                class="input @error('category') is-danger @enderror"
                                type="category"
                                id="category"
                                name="category"
                        >
                            <option value="mechanical">Mechanical error</option>
                            <option value="technical">Technical error</option>
                        </select>
                    </div>
                    <br>
                    @error('category')
                    <p class="help is-danger">This is a required field</p>
                    @enderror
                </div>

                <label for="description">Description:</label><br>
                <div class="label">
                    <div class="control has-icons-left has-icons-right">
                        <textarea
                                class="input @error('description') is-danger @enderror"
                                id="description"
                                name="description"
                                value="{{$errors->any() ? old('description') : ''}}"
                        //required
                        ></textarea>
                    </div>
                    <br>
                    @error('description')
                    <p class="help is-danger">This is a required field</p>
                    @enderror
                </div>

                <input type="submit" value="Submit" class="button is-link">
                <a href="{{route('error.index')}}">
                    <button type="button" class="button is-link-light">Cancel</button>
                </a>

            </form>
        </div>
    </section>
@endsection
