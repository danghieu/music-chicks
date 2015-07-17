@extends('main')
@section('title')
Search result
@endsection

@section('content')
@include('search',['zingSongs'=>$zingSongs,'mySongs'=>$mySongs])
@endsection
