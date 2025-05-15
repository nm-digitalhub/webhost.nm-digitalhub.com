@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto p-6 bg-white rounded shadow">
    <h2 class="text-xl font-bold mb-4">Report an Issue</h2>

    <form method="POST" action="{{ route('support.submit') }}">
        @csrf
        <input type="hidden" name="error_code" value="{{ $errorCode }}">
        <div class="mb-4">
            <label class="block font-medium">What went wrong?</label>
            <textarea name="message" required class="w-full border rounded p-2" rows="5" placeholder="Describe the issue..."></textarea>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Send Report</button>
    </form>
</div>
@endsection
