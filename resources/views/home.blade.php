@extends('layouts.template')

@section('content')
    <div class="valign-wrapper home-wrap">
        <div class="container">
            <div class="row no-margin">
                <div class="col l6 s12 center designer cta valign-wrapper">
                    <div class="row">
                        <div class="col s12">
                            @include("partials.designer")
                        </div>
                    </div>
                </div>
                <div class="col l6 s12 center coder cta valign-wrapper">
                    <div class="row">
                        <div class="col s12">
                            @include("partials.coder")
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection