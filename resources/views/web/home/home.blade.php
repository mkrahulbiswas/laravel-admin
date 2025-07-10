{{-- @extends('web.layouts.app')
@section('content') --}}
<form action="{{ route('web.uploadFileWeb') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file" id="file">
    <button>Submit</button>
</form>
{{-- @endsection --}}
