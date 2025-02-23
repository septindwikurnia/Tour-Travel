<script setup>
// Import ref dan onMounted
import { ref, onMounted } from "vue";

// Import API
import api from "../../api";

// State untuk menyimpan data bookings
const bookings = ref([]);

//method fetchDataPosts
const fetchDataPosts = async () => {
  //fetch data
  await api
    .get("/api/bookings")

    .then((response) => {
      //set response data to state "posts"
      bookings.value = response.data.data.data;
    });
};

//run hook "onMounted"
onMounted(() => {
  //call method "fetchDataPosts"
  fetchDataPosts();
});

//method deletePost
const deletePost = async (id) => {
  //delete post with API
  await api.delete(`/api/bookings/${id}`).then(() => {
    //call method "fetchDataPosts"
    fetchDataPosts();
  });
};
</script>

<template>
  <div class="container mt-5 mb-5">
    <div class="row">
      <div class="col-md-12">
        <!-- Tombol Tambah Booking -->
        <router-link
          :to="{ name: 'bookings.create' }"
          class="btn btn-success mb-3 rounded shadow border-0"
        >
          ADD NEW BOOKING
        </router-link>

        <!-- Card Container -->
        <div class="card border-0 rounded shadow">
          <div class="card-body">
            <!-- Tabel Bookings -->
            <table class="table table-bordered">
              <thead class="bg-dark text-white">
                <tr>
                  <th scope="col">Tour ID</th>
                  <th scope="col">Nama Pemesan</th>
                  <th scope="col">Email</th>
                  <th scope="col">Jumlah Orang</th>
                  <th scope="col">Tanggal</th>
                  <th scope="col" style="width: 20%">Actions</th>
                </tr>
              </thead>
              <tbody>
                <!-- Jika Data Kosong -->
                <tr v-if="bookings.length === 0">
                  <td colspan="6" class="text-center">
                    <div class="alert alert-danger mb-0">Data Belum Tersedia!</div>
                  </td>
                </tr>

                <!-- Menampilkan Data Booking -->
                <tr v-for="(booking, index) in bookings" :key="index">
                  <td>{{ booking.tour_id }}</td>
                  <td>{{ booking.nama_pemesan }}</td>
                  <td>{{ booking.email }}</td>
                  <td>{{ booking.jumlah_orang }}</td>
                  <td>{{ booking.tanggal }}</td>
                  <td class="text-center">
                    <!-- Tombol Edit -->
                    <router-link
                      :to="{ name: 'bookings.edit', params: { id: booking.id } }"
                      class="btn btn-sm btn-primary me-2 rounded shadow"
                    >
                      EDIT
                    </router-link>
                    <!-- Tombol Delete -->
                    <button
                      @click.prevent="deletePost(booking.id)"
                      class="btn btn-sm btn-danger rounded shadow"
                    >
                      DELETE
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
