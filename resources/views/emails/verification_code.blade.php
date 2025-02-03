@extends('include.master')

@section('content')
<h1>Your Verification Code</h1>
<p>Your 6-digit verification code is: <strong>{{ $code }}</strong></p>
<p>Please use this code to complete your registration.</p>
@endsection