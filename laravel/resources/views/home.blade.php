@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add a task</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form method="post" action="/task/add">
                      @csrf
                      <input type="text" name="title" required/>
                      <button type="submit" class="btn-primary">add task</button>
                    </form>
                </div>

                @foreach ($tasks as $task)
                  @if ($task['completed'] == 1)
                    <div class="card-body">
                      <strike>{{$task['title']}}</strike> <button class="btn-warning" disabled>completed</button>
                    </div>
                  @else
                  <div class="card-body">
                    {{$task['title']}} <a href="/task/delete/{{$task['id']}}"><button class="btn-danger">delete task</button></a> <a href="/task/complete/{{$task['id']}}"><button class="btn-success">Mark as completed</button></a>
                  </div>
                  @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
