@extends('layouts.app')
@section('title', '民事事件')
@section('content')
    <lawsuits-component :route_delete="{{ route('lawsuits.destroy') }}" :lawsuits="{{ $lawsuits }}" ></lawsuits-component>
@endsection