@extends('layouts.app')
@section('title', '書面閲覧画面')
@section('content')
    <lawsuits-document-show
        :type-documents="{{ $typeDocuments }}"
    ></lawsuits-document-show>
@endsection
