@extends('layouts.app')
@section('title', 'LDM Home')
@section('content')
    <folders-component :folders="{{ $folders }}"></folders-component>
@endsection