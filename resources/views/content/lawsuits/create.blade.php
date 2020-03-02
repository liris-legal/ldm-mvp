@extends('layouts.app')
@section('title', '新件を作成')
@section('content')
    <lawsuits-create
        :type-lawsuits="{{ $typeLawsuits }}"
        :store-route="'{{route('lawsuits.store', Auth::user()->id)}}'"
    ></lawsuits-create>
@endsection
