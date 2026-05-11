<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->string('search')->toString();
        $items = Item::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($searchQuery) use ($search) {
                    $searchQuery
                        ->where('item_name', 'like', '%' . $search . '%')
                        ->orWhere('description', 'like', '%' . $search . '%')
                        ->orWhere('location', 'like', '%' . $search . '%');
                });
            })
            ->latest()
            ->paginate(5)
            ->withQueryString();

        $totalItems = Item::count();

        return view('items.index', compact('items', 'search', 'totalItems'));
    }

    public function store(Request $request)
    {
        $data = $this->validateItem($request);
        $data['status'] = strtolower($data['status']);

        Item::create($data);

        return redirect()->route('items.index')->with('success', 'Item added successfully.');
    }

    public function edit(Item $item)
    {
        return view('items.edit', compact('item'));
    }

    public function update(Request $request, Item $item)
    {
        $data = $this->validateItem($request);
        $data['status'] = strtolower($data['status']);

        $item->update($data);

        return redirect()->route('items.index')->with('success', 'Item updated successfully.');
    }

    public function destroy(Item $item)
    {
        $item->delete();

        return redirect()->route('items.index')->with('success', 'Item deleted successfully.');
    }

    private function validateItem(Request $request): array
    {
        return $request->validate([
            'item_name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'status' => ['required', 'in:lost,found'],
            'location' => ['required', 'string', 'max:255'],
        ]);
    }
}
