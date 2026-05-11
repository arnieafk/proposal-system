@extends('layouts.main')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-lg-7">
            <div class="card card-modern">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Edit Item</span>
                    <a href="{{ route('items.index') }}" class="btn btn-sm btn-outline-secondary">Back</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('items.update', $item) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="item_name" class="form-label">Item Name</label>
                            <input id="item_name" type="text" name="item_name" value="{{ old('item_name', $item->item_name) }}" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea id="description" name="description" class="form-control" rows="3" placeholder="Describe the item..." required>{{ old('description', $item->description) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select id="status" name="status" class="form-select" required>
                                <option value="lost" @selected(old('status', $item->status) === 'lost')>Lost</option>
                                <option value="found" @selected(old('status', $item->status) === 'found')>Found</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input id="location" type="text" name="location" value="{{ old('location', $item->location) }}" class="form-control" placeholder="e.g. Quezon City Hall" required>
                        </div>

                        <button type="submit" class="btn btn-success">Update Item</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
