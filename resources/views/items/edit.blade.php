@extends('layouts.app')
@section('content')
@include('commons.errors')
<form action="{{ route('items.update.confirm', $item) }}" method="post">
    @include('items.form')
    <button type="submit">更新する</button>
    <div class="nav-item" style="display: inline-flex; align-items: center; margin-right: 5px;">
        <a class="btn btn-sm btn-dark" href="{{ route('items.index') }}">キャンセル</a>
    </div>
</form>
@endsection