@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h2>All Questions</h2>
                        <div class="ml-auto">
                            <a href="{{ route('questions.create')}}" class="btn btn-outline-secondary">Ask Question</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @include('layouts._messages')
                    @foreach($questions as $question)
                        <div class="media">
                            <div class="d-flex flex-colum counters">
                                <div class="vote">
                                    <strong>{{$question->votes}}</strong> {{ str_plural('vote',$question->vote)}}
                                </div>

                                <div class="{{$question->status}} status">
                                    <strong>{{$question->answers}}</strong> {{ str_plural('answer',$question->answers)}}
                                </div>

                                <div class="views">
                                    <strong>{{$question->views}}</strong>  {{str_plural('view',$question->views)}}
                                </div>
                            </div>
                            <div class="media-body">
                                <h3 class="mt-0">
                                    <a href="{{$question->url}}">{{$question->title}}</a></h3>
                                <p class="lead">
                                    Asked by
                                    <a href="{{$question->user->url}}">{{$question->user->name}}</a>
                                    <small class="text-muted">{{$question->created_date}}</small>
                                </p>
                                {!!str_limit($question->body,250)!!}
                            </div>
                        </div>
                        <hr>
                    @endforeach
                    <div class="center">
                        {!!$questions->links()!!}
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
