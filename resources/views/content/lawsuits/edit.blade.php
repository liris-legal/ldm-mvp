@extends('layouts.app')
@section('title', '事件を編集する画面')
@section('content')
    <lawsuits-edit :typeLawsuits="{{ $typeLawsuits }}"
                   :lawsuitId="{{ $lawsuitId }}"
    ></lawsuits-edit>
@endsection
