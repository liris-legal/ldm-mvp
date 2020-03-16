@extends('layouts.app')
@section('title', '民事事件')
@section('content')
<lawsuits-show
    :route-submitter-documents-index="'{{route('documents.index', [$lawsuitId, 'submitter', 'submitterId'])}}'"
    :type-documents="{{ $typeDocuments }}"
    :submitters="{{ $submitters }}"
></lawsuits-show>
@endsection
