@extends('layouts.app')
@section('title', 'ファイルをアップロード')
@section('content')
    <document-create :lawsuit-id="'{{ $lawsuitId }}'" :store-route="'{{route('documents.store')}}'"></document-create>
@endsection
