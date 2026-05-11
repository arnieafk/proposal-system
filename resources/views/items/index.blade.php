@extends('layouts.main')

@section('content')
    <div class="row g-4">
        <div class="col-12 d-flex flex-wrap justify-content-between align-items-center gap-2 mb-1">
            <div>
                <h2 class="mb-1 fw-bold">Online Lost & Found Hub</h2>
                <p class="text-subtle mb-0">Total posted items: <strong>{{ $totalItems }}</strong></p>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card card-modern">
                <div class="card-header">Add New Item</div>
                <div class="card-body">
                    <form action="{{ route('items.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="item_name" class="form-label">Item Name</label>
                            <input id="item_name" type="text" name="item_name" class="form-control" value="{{ old('item_name') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea id="description" name="description" class="form-control" rows="3" placeholder="Describe the item..." required>{{ old('description') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select id="status" name="status" class="form-select" required>
                                <option value="">Select status</option>
                                <option value="lost" @selected(old('status') === 'lost')>Lost</option>
                                <option value="found" @selected(old('status') === 'found')>Found</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input id="location" type="text" name="location" class="form-control" value="{{ old('location') }}" placeholder="e.g. UP Diliman Main Gate" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Add Item</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-8">
            <div class="card card-modern">
                <div class="card-body">
                    <form method="GET" action="{{ route('items.index') }}" class="row g-2 mb-3">
                        <div class="col-sm-8">
                            <input type="text" name="search" value="{{ $search }}" placeholder="Search by item name, description, or location..." class="form-control">
                        </div>
                        <div class="col-sm-4 d-grid d-sm-flex gap-2">
                            <button type="submit" class="btn btn-outline-primary">Search</button>
                            <a href="{{ route('items.index') }}" class="btn btn-outline-secondary">Reset</a>
                        </div>
                    </form>

                    <div class="row g-3">
                        @forelse($items as $item)
                            <div class="col-12 col-md-6">
                                <article class="item-card h-100 p-3 d-flex flex-column">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <h5 class="mb-0 fw-semibold">{{ $item->item_name }}</h5>
                                        <span class="badge {{ $item->status === 'lost' ? 'badge-soft-lost' : 'badge-soft-found' }}">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </div>

                                    <div class="mb-3">
                                        <span class="item-location">📍 {{ $item->location }}</span>
                                    </div>

                                    <p class="item-description flex-grow-1 mb-3">
                                        {{ \Illuminate\Support\Str::limit($item->description, 160) }}
                                    </p>

                                    <div class="d-flex gap-2">
                                        <a href="{{ route('items.edit', $item) }}" class="btn btn-sm btn-outline-primary flex-fill">Edit</a>
                                        <form action="{{ route('items.destroy', $item) }}" method="POST" class="flex-fill" onsubmit="return confirm('Delete this item?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger w-100">Delete</button>
                                        </form>
                                    </div>
                                </article>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="text-center text-subtle py-5">No items found.</div>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-3">
                        {{ $items->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
