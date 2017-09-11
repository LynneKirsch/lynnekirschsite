@extends('layouts.template')

@section('content')
    <main id="main-page-content" class="valign-wrapper">
        <div class="row no-margin " id="content-inner">
            <div class="col s12">
                <div class="container grey-text text-darken-4 body">
                    <div class="inner">
                        <div class="row">
                            <div class="col s12">
                                <p>
                                    Feel free to contact me with any questions you might have! <br><br>
                                    Email: lynne.kirsch@gmail.com<br>
                                    Mobile: 607.342.5016<br><br>
                                    Or use the form below:
                                </p>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input id="company" type="text" class="validate" >
                                        <label for="company" data-error="wrong" data-success="right">Company</label>
                                    </div>
                                    <div class="input-field col s12">
                                        <input id="email" type="email" class="validate" >
                                        <label for="email" data-error="wrong" data-success="right">Email</label>
                                    </div>
                                    <div class="input-field col s12">
                                        <textarea id="textarea1" class="materialize-textarea"></textarea>
                                        <label for="textarea1">Message</label>
                                    </div>
                                    <div class="col s12">
                                        <button class="btn">Send</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>


@endsection