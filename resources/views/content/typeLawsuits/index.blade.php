@extends('layouts.app')
@section('title', 'LDM Home')
@section('content')
    <type-lawsuits :type-lawsuits="{{ $typeLawsuits }}"></type-lawsuits>
@endsection
