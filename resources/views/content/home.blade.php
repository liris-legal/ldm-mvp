@extends('layouts.app')
@section('title', '最近表示画面')
@section('content')
    <app-home :documents="{{ $documents }}"></app-home>
@endsection
