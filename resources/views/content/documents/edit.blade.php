@extends('layouts.app')
@section('title', 'ファイルの名前を変更する画面')
@section('content')
    <document-edit
        :lawsuit-id="'{{ $lawsuitId }}'"
       :document-id="'{{ $documentId }}'"
       :submitters="{{ $submitters }}"
       :type-documents="{{ $typeDocuments }}"
       :update-route="'{{route('documents.update', [Auth::user()->id, $documentId])}}'"
    ></document-edit>
@endsection
