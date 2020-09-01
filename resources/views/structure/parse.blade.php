@extends('layouts.app')
@section('content')
    @role('admin')
    <parse>

    </parse>
    @endrole
    @if(Auth::id() == 5 )
    <parse-not-admin>

    </parse-not-admin>
    @endif
@endsection
