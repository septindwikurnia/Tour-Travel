<script setup>
// Import ref dan onMounted
import { ref, onMounted } from "vue";

// Import router dan route
import { useRouter, useRoute } from "vue-router";

// Import API
import api from "../../api";

// Inisialisasi router dan route
const router = useRouter();
const route = useRoute();

// State untuk menyimpan input dari form
const tour_id = ref("");
const nama_pemesan = ref("");
const email = ref("");
const jumlah_orang = ref("");
const tanggal = ref("");
const errors = ref([]);

// onMounted: Ambil data berdasarkan ID
onMounted(async () => {
  await api
    .get(`/api/bookings/${route.params.id}`)
    .then((response) => {
      // Assign data ke state
      const data = response.data.data;
      tour_id.value = data.tour_id;
      nama_pemesan.value = data.nama_pemesan;
      email.value = data.email;
      jumlah_orang.value = data.jumlah_orang;
      tanggal.value = data.tanggal;
    })
    .catch((error) => {
      console.log(error);
    });
});

// Method "updateBooking"
const updateBooking = async () => {
  // Buat formData
  let formData = new FormData();

  // Assign nilai input ke formData
  formData.append("tour_id", tour_id.value);
  formData.append("nama_pemesan", nama_pemesan.value);
  formData.append("email", email.value);
  formData.append("jumlah_orang", jumlah_orang.value);
  formData.append("tanggal", tanggal.value);
  formData.append("_method", "PATCH");

  // Kirim request ke API
  await api
    .post(`/api/bookings/${route.params.id}`, formData)
    .then(() => {
      // Redirect ke halaman daftar bookings
      router.push({ path: "/bookings" });
    })
    .catch((error) => {
      // Assign error ke state errors
      errors.value = error.response.data.errors;
    });
};
</script>
<template>
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-12">
        <div class="card border-0 rounded shadow">
          <div class="card-body">
            <form @submit.prevent="updateBooking()">
              <!-- Tour ID -->
              <div class="mb-3">
                <label class="form-label fw-bold">Tour ID</label>
                <input
                  type="number"
                  class="form-control"
                  v-model="tour_id"
                  placeholder="Masukkan Tour ID"
                />
                <div v-if="errors.tour_id" class="alert alert-danger mt-2">
                  <span>{{ errors.tour_id[0] }}</span>
                </div>
              </div>

              <!-- Nama Pemesan -->
              <div class="mb-3">
                <label class="form-label fw-bold">Nama Pemesan</label>
                <input
                  type="text"
                  class="form-control"
                  v-model="nama_pemesan"
                  placeholder="Masukkan Nama Pemesan"
                />
                <div v-if="errors.nama_pemesan" class="alert alert-danger mt-2">
                  <span>{{ errors.nama_pemesan[0] }}</span>
                </div>
              </div>

              <!-- Email -->
              <div class="mb-3">
                <label class="form-label fw-bold">Email</label>
                <input
                  type="email"
                  class="form-control"
                  v-model="email"
                  placeholder="Masukkan Email"
                />
                <div v-if="errors.email" class="alert alert-danger mt-2">
                  <span>{{ errors.email[0] }}</span>
                </div>
              </div>

              <!-- Jumlah Orang -->
              <div class="mb-3">
                <label class="form-label fw-bold">Jumlah Orang</label>
                <input
                  type="number"
                  class="form-control"
                  v-model="jumlah_orang"
                  placeholder="Masukkan Jumlah Orang"
                />
                <div v-if="errors.jumlah_orang" class="alert alert-danger mt-2">
                  <span>{{ errors.jumlah_orang[0] }}</span>
                </div>
              </div>

              <!-- Tanggal -->
              <div class="mb-3">
                <label class="form-label fw-bold">Tanggal</label>
                <input
                  type="date"
                  class="form-control"
                  v-model="tanggal"
                />
                <div v-if="errors.tanggal" class="alert alert-danger mt-2">
                  <span>{{ errors.tanggal[0] }}</span>
                </div>
              </div>

              <!-- Tombol Update -->
              <button
                type="submit"
                class="btn btn-md btn-primary rounded-sm shadow border-0"
              >
                Update
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
