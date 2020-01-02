@extends('layouts.app')
@section('title', '事件を編集画面')
@section('content')
    <lawsuits-edit :type_lawsuits="{{ $typeLawsuits }}"
                   :lawsuit="{{ $lawsuit}}"
    ></lawsuits-edit>
@endsection
