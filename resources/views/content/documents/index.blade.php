@extends('layouts.app')
@section('title', '原告側書面する画面')
@section('content')
    <document-index :lawsuit-id="'{{ $lawsuitId }}'"></document-index>
@endsection
