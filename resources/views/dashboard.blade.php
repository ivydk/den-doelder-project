@extends('layouts.master')
@section('content')
    <section class="section">
        <div class="container">
            @can('is_admin')
                <h1>Je bent ingelog als admin</h1>
                <div class="tile is-ancestor">
                    <div class="tile is-parent is-vertical">
                        <a href="{{ route('orders.index')  }}">
                            <article class="tile is-child box">
                                <p class="title text-lg-center">Orders</p>
                            </article>
                        </a>
                    </div>
                </div>

                <div class="tile is-ancestor">
                    <div class="tile is-parent is-vertical">
                        <a href="{{ route('error.index')  }}">
                            <article class="tile is-child box">
                                <p class="title text-lg-center">Backlog</p>
                            </article>
                        </a>
                    </div>
                </div>

                <div class="tile is-ancestor">
                    <div class="tile is-parent is-vertical">
                        <a href="{{ route('qualityControl.index')  }}">
                            <article class="tile is-child box">
                                <p class="title text-lg-center">Qualitycontrol</p>
                            </article>
                        </a>
                    </div>
                </div>

            @else
                <h1>Je bent ingelogd als production</h1>
                <div class="tile is-ancestor">
                    <div class="tile is-parent is-vertical">
                        <a href="{{ route('orders.index')  }}">
                            <article class="tile is-child box">
                                <p class="title text-lg-center">Orders</p>
                            </article>
                        </a>
                    </div>
                </div>
                <div class="tile is-ancestor">
                    <div class="tile is-parent is-vertical">
                        <a href="{{ route('qualityControl.index')  }}">
                            <article class="tile is-child box">
                                <p class="title text-lg-center">Qualitcontrol</p>
                            </article>
                        </a>
                    </div>
                </div>
            @endcan
        </div>
    </section>
@endsection
