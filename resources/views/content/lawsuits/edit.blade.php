@extends('layouts.app')
@section('title', '事件を編集する画面')
@section('content')
    <lawsuits-edit :type-lawsuits="{{ $typeLawsuits }}" :lawsuit-id="'{{ $lawsuitId }}'"></lawsuits-edit>
@endsection
