@extends('layouts.app')
@section('title', '民事事件')
@section('content')
<lawsuits-show
    :route-plaintiff-documents-index="'{{route('documents.index', [$lawsuitId, 'plaintiff'])}}'"
    :route-defendant-documents-index="'{{route('documents.index', [$lawsuitId, 'defendant'])}}'"
></lawsuits-show>
@endsection
