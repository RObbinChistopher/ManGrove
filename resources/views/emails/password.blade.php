@extends('include.master')

@section('content')
<p>This is the login Page. Click this to get there.</p>
<p><strong><a href="{{ url('/password') }}">{{ url('/password') }}</a></strong></p>

<!-- Add Email Text Here -->
<p>If you didn't request this, please ignore this email. Otherwise, use the link above to log in to your account.</p>
@endsection
