<template>
  <div class="bg-secondary">
    <div
      class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8"
    >
      <div class="flex justify-between items-center mb-6">
        <div>
          <h2 class="text-2xl font-bold tracking-tight text-primary">
            Products - {{ selectedType ? selectedType : "All" }}
          </h2>
        </div>
        <div class="flex flex-col items-start justify-center">
          <label for="instrument" class="text-sm font-medium text-white"
            >Filter by instrument:</label
          >
          <select
            v-model="selectedType"
            id="instrument"
            class="block w-[15vw] rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary bg-white text-gray-900"
            style="background-color: #f79010; color: white"
          >
            <option value="">All</option>
            <option
              v-for="instrument in instrumentOptions"
              :key="instrument"
              :value="instrument"
            >
              {{ instrument }}
            </option>
          </select>
        </div>
      </div>

      <div
        class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8"
      >
        <div
          v-for="product in filteredProducts"
          :key="product.id"
          class="group relative"
        >
        <router-link :to="'/singleProduct?item_name=' + product.name">
            <div
              class="min-h-80 aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80"
            >
              <img
                :src="product.imageSrc"
                :alt="product.imageAlt"
                class="h-full w-full object-cover object-center lg:h-full lg:w-full"
              />
            </div>
            <div class="mt-4 flex justify-between">
              <div>
                <h3 class="text-sm text-primary">
                  <span aria-hidden="true" class="absolute inset-0"></span>
                  {{ product.name }}
                </h3>
                <p class="mt-1 text-sm text-white">{{ product.color }}</p>
              </div>
              <p class="text-sm font-medium text-white">{{ product.price }}</p>
            </div>
          </router-link>
        </div>
      </div>
    </div>
  </div>

  <shopCart />
</template>

<script>
import axios from "axios";
import shopCart from "./shopCart.vue";

export default {
  components: {
    shopCart,
  },
  data() {
    return {
      products: [],
      instrumentOptions: [
        "Guitars",
        "Piano",
        "Percussion",
        "Wind",
        "Violins & Family",
        "Bass",
      ],
      selectedType: "",
    };
  },
  computed: {
    filteredProducts() {
      if (this.selectedType === "") {
        return this.products;
      } else {
        return this.products.filter(
          (product) => product.type === this.selectedType
        );
      }
    },
  },
  methods: {
    fetchInstruments() {
      axios
        .get("http://localhost/Tunezz/Tunezz/APIs/appfunctions/get_instruments.php")
        .then((response) => {
          this.products = response.data.map((instrument, index) => {
            console.log("/assets/" + instrument.pic);
            return {
              id: index + 1,
              name: instrument.name,
              href: "#",
              imageSrc: "http://localhost/Tunezz/Tunezz/src/assets/" + instrument.pic
,
              imageAlt: `Front of ${instrument.name}`,
              price: `$${instrument.price}`,
              color: "", // You'll need to add color in the PHP API response or handle it differently
              type: instrument.type,
            };
          });
        })
        .catch((error) => {
          console.error("Error fetching instruments:", error);
        });
    },
  },
  mounted() {
    this.fetchInstruments();
  },
};
</script>