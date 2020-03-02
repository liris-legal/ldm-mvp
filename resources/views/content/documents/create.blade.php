@extends('layouts.app')
@section('title', 'ファイルをアップロード画面')
@section('content')
    <document-create :lawsuit-id="'{{ $lawsuitId }}'"
                     :type-documents="{{ $typeDocuments }}"
                     :submitters="{{ $submitters }}"
                     :store-route="'{{route('documents.store', Auth::user()->id)}}'"
    >
    </document-create>
@endsection
