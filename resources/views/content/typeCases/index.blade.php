@extends('layouts.app')
@section('title', 'LDM Home')
@section('content')
    <folders-component :folders="{{ $typeCase }}"></folders-component>
@endsection