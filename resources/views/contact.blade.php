@extends('layouts.app')

@section('content')

<h3>Contact ID : <strong>{{Auth::id()}}</strong><br></h3>
<h3>Contact Name : <strong>{{Auth::user()->name}}</strong><br></h3>
<h3>Contact All Info : <strong>{{Auth::user()}}</strong></h3>
@endsection