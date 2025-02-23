<?php

namespace App\Http\Controllers\Api;

use App\Models\Booking;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('tour')->latest()->paginate(5);
        return new BookingResource(true, 'List Data Bookings', $bookings);
    }

    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'tour_id' => 'required|exists:tours,id', // Pastikan tour_id ada di tabel tours
            'nama_pemesan' => 'required',
            'email' => 'required|email',
            'jumlah_orang' => 'required|integer|min:1',
            'tanggal' => 'required|date',
        ]);

        // Jika validasi gagal, kembalikan error
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Membuat booking baru
        $booking = Booking::create($request->all());

        // Ambil nama tour berdasarkan ID tour dari relasi
        $tour = $booking->tour; // Relasi 'tour' harus ada di model Booking

        // Sertakan data nama tour saat merespons
        return new BookingResource(true, 'Data Booking Berhasil Ditambahkan!', [
            'booking' => $booking,
            'tour_name' => $tour->name, // Menambahkan nama tour ke response
        ]);
    }

    public function show($id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json(['error' => 'Booking not found'], 404);
        }

        return new BookingResource(true, 'Detail Data Booking!', $booking);
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json(['error' => 'Booking not found'], 404);
        }

        // Validasi input update
        $validator = Validator::make($request->all(), [
            'tour_id' => 'sometimes|required|exists:tours,id', // Tour ID optional saat update
            'nama_pemesan' => 'sometimes|required',
            'email' => 'sometimes|required|email',
            'jumlah_orang' => 'sometimes|required|integer|min:1',
            'tanggal' => 'sometimes|required|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Update booking dengan data baru
        $booking->update($request->all());

        // Ambil nama tour berdasarkan ID tour
        $tour = $booking->tour; // Relasi 'tour' harus ada di model Booking

        // Sertakan nama tour saat merespons
        return new BookingResource(true, 'Data Booking Berhasil Diupdate!', [
            'booking' => $booking,
            'tour_name' => $tour->name, // Menambahkan nama tour ke response
        ]);
    }

    public function destroy($id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json(['error' => 'Booking not found'], 404);
        }

        $booking->delete();
        return new BookingResource(true, 'Data Booking Berhasil Dihapus!', null);
    }
}
