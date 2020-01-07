@extends('layouts.app')
@section('title', 'ファイルをアップロード画面')
@section('content')
    <document-create :lawsuit-id="'{{ $lawsuitId }}'"
                     :type-documents="{{ $typeDocuments }}"
                     :store-route="'{{route('documents.store')}}'"
    >
    </document-create>
@endsection
