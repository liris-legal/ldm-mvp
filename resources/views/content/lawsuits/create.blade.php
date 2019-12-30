@extends('layouts.app')
@section('title', '新件を作成')
@section('content')
    <lawsuits-create :type_lawsuits="{{ $typeLawsuits }}" :store_route="'{{route('lawsuits.store')}}'"></lawsuits-create>
@endsection
