@extends('layouts.app')
@section('title', '民事事件')
@section('content')
    <cases-component :cases="{{ $cases }}" ></cases-component>
@endsection