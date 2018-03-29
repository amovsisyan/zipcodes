@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col s12">
                <div class="col s12">
                    <div class="row">
                        <div class="input-field col s12">
                            <select id="country-select">
                                <option value="" disabled selected>Choose your option</option>
                                @if(!empty($response) && isset($response['countries']) && !empty($response['countries']))
                                    @foreach($response['countries'] as $country)
                                        <option value="{{$country['id']}}">{{$country['name']}} - {{$country['abbr']}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
                <div class="input-field col s12">
                    <input id="post-code" type="text" class="validate">
                    <label for="post-code">Post Code</label>
                </div>
                <a class="waves-effect waves-light btn" id="sendRequestBtn">Get Place(s)</a>
            </div>
            @include('results')
        </div>
    </div>
@endsection

@section('scripts')
    <script src="/js/zipcode.js"></script>
@endsection