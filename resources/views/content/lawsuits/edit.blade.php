@extends('layouts.app')
@section('title', '事件を編集する画面')
@section('content')
    <lawsuits-edit :type_lawsuits="{{ $typeLawsuits }}"
                   :lawsuit_id="{{ $lawsuitId }}"
    ></lawsuits-edit>
@endsection
