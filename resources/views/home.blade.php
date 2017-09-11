@extends('layouts.template')

@section('content')
    <div id="main-page-content" class="valign-wrapper">
        <div class="row no-margin " id="content-inner">
            <div class="col s12">
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
        </div>
    </div>
@endsection