<script setup>
//import ref
import { ref } from "vue";

//import router
import { useRouter } from "vue-router";

//import api
import api from "../../api";

//init router
const router = useRouter();

//define state
const image = ref("");
const nama_tours = ref("");
const deskripsi = ref("");
const harga = ref("");
const errors = ref([]);

//method for handle file changes
const handleFileChange = (e) => {
  //assign file to state
  image.value = e.target.files[0];
};

//method "storePost"
const storePost = async () => {
  //init formData
  let formData = new FormData();

  //assign state value to formData
  formData.append("image", image.value);
  formData.append("nama_tours", nama_tours.value);
  formData.append("deskripsi", deskripsi.value);
  formData.append("harga", harga.value);

  //store data with API
  await api
    .post("/api/tours", formData)
    .then(() => {
      //redirect
      router.push({ path: "/tours" });
    })
    .catch((error) => {
      //assign response error data to state "errors"
      errors.value = error.response.data;
    });
};
</script>

<template>
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-12">
        <div class="card border-0 rounded shadow">
          <div class="card-body">
            <form @submit.prevent="storePost()">
              <div class="mb-3">
                <label class="form-label fw-bold">Image</label>
                <input
                  type="file"
                  class="form-control"
                  @change="handleFileChange($event)"
                />
                <div v-if="errors.image" class="alert alert-danger mt-2">
                  <span>{{ errors.image[0] }}</span>
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label fw-bold">Nama Tours</label>
                <input
                  type="text"
                  class="form-control"
                  v-model="nama_tours"
                  placeholder="Nama Tours"
                />
                <div v-if="errors.nama_tours" class="alert alert-danger mt-2">
                  <span>{{ errors.nama_tours[0] }}</span>
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label fw-bold">Deskripsi</label>
                <textarea
                  class="form-control"
                  v-model="deskripsi"
                  rows="5"
                  placeholder="Content Post"
                ></textarea>
                <div v-if="errors.deskripsi" class="alert alert-danger mt-2">
                  <span>{{ errors.deskripsi[0] }}</span>
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label fw-bold">Harga</label>
                <input
                  type="text"
                  class="form-control"
                  v-model="harga"
                  placeholder="Harga"
                />
                <div v-if="errors.harga" class="alert alert-danger mt-2">
                  <span>{{ errors.harga[0] }}</span>
                </div>
              </div>
              <button
                type="submit"
                class="btn btn-md btn-primary rounded-sm shadow border-0"
              >
                Save
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
