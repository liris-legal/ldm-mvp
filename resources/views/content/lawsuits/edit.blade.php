@extends('layouts.app')
@section('title', '名前を変更')
@section('content')
    <lawsuits-edit :lawsuit="{{ $lawsuit }}"></lawsuits-edit>
@endsection