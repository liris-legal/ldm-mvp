@extends('layouts.app')
@section('title', '民事事件')
@section('content')
    <lawsuits-component :lawsuits="{{ $lawsuits }}" ></lawsuits-component>
@endsection