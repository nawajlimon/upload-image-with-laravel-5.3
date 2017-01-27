@extends('layouts.app')

@section('content')
	
	<h1>Create New Post</h1>

	{!! Form::model($post, [
			'method' => $post->exists ? 'PUT' : 'POST',
			'route' => $post->exists ? ['posts.update', $post->id] : ['posts.store'],
			'enctype' => 'multipart/form-data',
			'files' => true
		]) !!}

		<div class="form-group">
			{!! Form::label('title') !!}
			{!! Form::text('title', null, ['class'=>'form-control']) !!}
		</div>

		<div class="form-group">
			{!! Form::label('image') !!}
			{!! Form::file('image', null, ['class'=>'form-control']) !!}
		</div>

		<div class="form-group">
			{!! Form::label('body') !!}
			{!! Form::textarea('body', null, ['class'=>'form-control']) !!}
		</div>

		{!! Form::submit('Save', ['class'=>'btn btn-success']) !!}

	{!! Form::close() !!}

@endsection