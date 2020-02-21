@extends('layouts.app')
@section('title', '名前を変更する画面')
@section('content')
    <lawsuits-edit :type-lawsuits="{{ $typeLawsuits }}" :lawsuit-id="'{{ $lawsuitId }}'"></lawsuits-edit>
@endsection
