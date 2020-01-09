@extends('layouts.app')
@section('title', 'ファイルの名前を変更する画面')
@section('content')
    <document-edit :lawsuit-id="'{{ $lawsuitId }}'"
                   :document-id="'{{ $documentId }}'"
                   :type-documents="{{ $typeDocuments }}"
                   :update-route="'{{route('documents.update', $documentId)}}'"
    >
    </document-edit>
@endsection
