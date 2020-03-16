@extends('layouts.app')
@section('title', '事件種類画面')
@section('content')
    <type-lawsuits :type-lawsuits="{{ $typeLawsuits }}" :route-lawsuits-index="'{{ route('lawsuits.index') }}'"></type-lawsuits>
@endsection
