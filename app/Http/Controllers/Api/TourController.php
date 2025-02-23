<?php

namespace App\Http\Controllers\Api;

use App\Models\Tours;
use App\Http\Controllers\Controller;
use App\Http\Resources\TourResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class TourController extends Controller
{
    public function index()
    {
        // get all tours
        $tours = Tours::latest()->paginate(5);
        // return collection of tours as a resource
        return new TourResource(true, 'List Data Tours', $tours);
    }

    public function store(Request $request)
    {
        // define validation rules
        $validator = Validator::make($request->all(), [
            'nama_tours' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // upload image
        $image = $request->file('image');
        $image->storeAs('tours', $image->hashName(), 'public');

        // create tour
        $tour = Tours::create([
            'nama_tours' => $request->nama_tours,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'image' => $image->hashName(),
        ]);

        // return response
        return new TourResource(true, 'Data Tour Berhasil Ditambahkan!', $tour);
    }

    public function show($id)
    {
        // find tour by ID
        $tour = Tours::find($id);

        if (!$tour) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        // return single tour as a resource
        return new TourResource(true, 'Detail Data Tour!', $tour);
    }

    public function update(Request $request, $id)
    {
        // define validation rules
        $validator = Validator::make($request->all(), [
            'nama_tours' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required',
        ]);

        // check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // find tour by ID
        $tour = Tours::find($id);

        if (!$tour) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        // check if image is not empty
        if ($request->hasFile('image')) {
            // upload image
            $image = $request->file('image');
            $image->storeAs('tours', $image->hashName(), 'public');

            // delete old image
            Storage::disk('public')->delete('tours/' . basename($tour->image));

            // update tour with new image
            $tour->update([
                'nama_tours' => $request->nama_tours,
                'deskripsi' => $request->deskripsi,
                'harga' => $request->harga,
                'image' => $image->hashName(),
            ]);
        } else {
            // update tour without image
            $tour->update([
                'nama_tours' => $request->nama_tours,
                'deskripsi' => $request->deskripsi,
                'harga' => $request->harga,
            ]);
        }

        // return response
        return new TourResource(true, 'Data Tour Berhasil Diubah!', $tour);
    }

    public function destroy($id)
    {
        // find tour by ID
        $tour = Tours::find($id);

        if (!$tour) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        // delete image
        Storage::disk('public')->delete('tours/' . basename($tour->image));

        // delete tour
        $tour->delete();

        // return response
        return new TourResource(true, 'Data Tour Berhasil Dihapus!', null);
    }
}
