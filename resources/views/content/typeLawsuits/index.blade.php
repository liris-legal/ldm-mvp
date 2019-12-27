@extends('layouts.app')
@section('title', 'LDM Home')
@section('content')
    <type-lawsuits :type_lawsuits="{{ $typeLawsuits }}"></type-lawsuits>
@endsection