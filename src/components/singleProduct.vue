<template>
  <!-- Product Image And details -->
  <div
    class="bg-secondary lg:flex-row justify-center items-center w-full h-auto overflow-auto flex-col pt-6 lg:pt-0"
  >
    <div
      class="flex flex-col items-center justify-center md:flex-row h-fit relative pt-6 sm:pt-0"
    >
      <!-- Image gallery -->
      <div
        class="px-6 sm:w-1/3 w-full flex items-center justify-center relative"
      >
        <div class="w-full h-[600px] max-w-full">
          <img
            :src='"http://localhost/Tunezz/Tunezz/src/assets/" +product.image'
            
            alt="Product Image"
            class="w-full h-full object-cover rounded-md"
          />
        </div>
      </div>

      <!-- Product info -->
      <div
        class="w-full md:w-1/2 mx-auto max-w-2xl px-4 pb-16 pt-10 sm:px-6 lg:grid lg:max-w-7xl lg:grid-cols-3 lg:grid-rows-[auto,auto,1fr] lg:gap-x-8 lg:px-8 lg:pb-24 lg:pt-16"
      >
        <div class="lg:col-span-2 lg:border-r lg:border-gray-200 lg:pr-8">
          <h1
            class="text-2xl font-bold tracking-tight text-primary sm:text-3xl"
          >
            {{ product.name }}
          </h1>
        </div>

        <!-- Options -->
        <div class="mt-4 lg:row-span-3 lg:mt-0">
          <h2 class="sr-only">Product information</h2>
          <p class="text-3xl tracking-tight text-primary">
            {{ product.price }}$
          </p>

          <!-- Reviews -->

          <form class="mt-10">


            <button
              type="cartadd"
              class="mt-10 flex w-full items-center justify-center rounded-md border border-transparent bg-primary px-8 py-3 text-base font-medium text-white hover:bg-primary/80 active:translate-y-0.5 transition-all duration-200 ease-in-out"
              @click="handleAddToCart"
            >
              Add to bag
            </button>
          </form>
        </div>

        <div
          class="py-10 lg:col-span-2 lg:col-start-1 lg:border-r lg:border-gray-200 lg:pb-16 lg:pr-8 lg:pt-6"
        >
          <!-- Description and details -->
          <div>
            <h3 class="sr-only">Description</h3>

            <div class="space-y-6">
              <p class="text-base text-white">{{ product.description }}</p>
            </div>
          </div>


          <div class="mt-10">
            <h2 class="text-sm font-medium text-primary">Details</h2>

            <div class="mt-4 space-y-6">
              <p class="text-sm text-white">{{ product.details }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Review section -->
  <div
    class="w-full mx-auto px-4 py-8 flex flex-col lg:flex-row justify-evenly items-center"
  >
    <div class="mb-8 lg:w-2/3 p-10 w-full">
      <h2 class="text-2xl font-bold mb-4 text-primary">Reviews</h2>
      <ul role="list" class="divide-y divide-gray-100">
        <li
          v-for="review in reviews.slice(0, 10)"
          :key="review.id"
          class="py-4"
        >
          <div class="flex justify-between items-center">
            <h3 class="text-lg font-medium text-primary">{{ review.email }}</h3>
          </div>
          <p class="text-white mt-2">{{ review.review }}</p>
         
        </li>
      </ul>
    </div>
    <div class="lg:w-1/3 p-10 w-full">
      <h2 class="text-2xl font-bold mb-4 text-primary">Write a Review</h2>
      <form @submit.prevent="submitReview">
       
        <div class="mb-4">
          <label for="content" class="text-primary">Review</label>
          <textarea
            id="content"
            v-model="newReview.content"
            rows="4"
            class="mt-2 block w-full rounded-md bg-gray-100 bg-opacity-70 border-transparent focus:border-primary focus:bg-white focus:ring-0 px-4 py-3 text-lg"
          ></textarea>
        </div>
        <button
          type="submit"
          class="px-4 py-2 bg-primary text-white font-medium rounded"
          
        >
          Submit Review
        </button>
      </form>
    </div>
  </div>
</template>

<!--SCRIPT-->
<script setup>
import { ref, computed, onMounted , reactive } from 'vue';
import { useRoute } from 'vue-router';
import axios from 'axios';

import { RadioGroup, RadioGroupLabel, RadioGroupOption } from "@headlessui/vue";
// StarRating component
// const StarRating = {
//   props: ["rating"],
//   methods: {
//     setRating(rating) {
//       this.$emit("update:rating", rating);
//     },
//   },
//   template: `
//     <div>
//       <span
//         v-for="star in 5"
//         :key="star"
//         @click="setRating(star)"
//         :class="[
//           'text-yellow-400',
//           'hover:text-yellow-500',
//           'cursor-pointer',
//           star <= rating ? 'text-yellow-500' : 'text-gray-300'
//         ]"
//       >
//         &#9733;
//       </span>
//     </div>
//   `,
// };

// const reviews = [
//   {
//     id: 1,
//     email: "john@example.com",
//     date: "2023-05-10",
//     content: "Great product!",
//     rating: 5,
//   },
//   {
//     id: 1,
//     email: "john@example.com",
//     date: "2023-05-10",
//     content: "Great product!",
//     rating: 5,
//   },
//   {
//     id: 1,
//     email: "john@example.com",
//     date: "2023-05-10",
//     content: "Great product!",
//     rating: 5,
//   },
//   {
//     id: 2,
//     email: "jane@example.com",
//     date: "2023-05-09",
//     content: "Love it!",
//     rating: 4,
//   },
//   // Add more review objects here
// ];

// const newReview = ref({
//   author: "",
//   content: "",
// });

// const submitReview = () => {
//   if (newReview.value.author && newReview.value.content) {
//     const review = {
//       id: reviews.value.length + 1,
//       author: newReview.value.author,
//       date: new Date().toLocaleDateString("en-US", {
//         month: "long",
//         day: "numeric",
//         year: "numeric",
//       }),
//       content: newReview.value.content,
//     };
//     reviews.value.unshift(review);
//     newReview.value.author = "";
//     newReview.value.content = "";
//   }
// };
const product = reactive({
  name: '',
  price: '',
  image: '',
  description: '',
  details: ''
});
const userEmail = ref('');
const reviews = ref([]);
const newReview = ref({ email: "", rating: 0, content: "" });

const fetchUserEmail = async () => {
  try {
    const response = await axios.get("http://localhost/Tunezz/Tunezz/APIs/appfunctions/session.php", {
      headers: {
        "Session-ID": localStorage.getItem("session_id")
      }
    });
    userEmail.value = response.data;
    console.log("User email:", userEmail.value);
  } catch (error) {
    console.error("Error:", error);
  }
};
const fetchReviews = async () => {
  console.log("Product name:", product.name);
  
  try {
    const url = encodeURIComponent(`http://localhost/Tunezz/Tunezz/APIs/get_review.php?instrument_name=${product.name.replace(" ", '')}`);

    console.log(url);
    // const response = await fetch(url, { mode: "cors" });
    const response = await fetch(`http://localhost/Tunezz/Tunezz/APIs/appfunctions/get_review.php?instrument_name=${product.name}`, { mode: "cors" });

    const data = await response.json();
    if (Array.isArray(data)) {
      reviews.value = data.map(review => {
        return {
          email: review.email,
          rating: review.rating,
          review: review.review
        }
      });
      console.log(reviews.value);
      console.log(data);
    } else {
      console.log("Error fetching reviews:", data);
    }
  } catch (error) {
    console.error("Error:", error);
  }
};


const fetchProductData = async () => {
  const route = useRoute();
  const itemName = route.query.item_name;
  const response = await fetch(`http://localhost/Tunezz/Tunezz/APIs/appfunctions/singleproduct.php?item_name=${itemName}`);
  const data = await response.json();
  console.log("Fetched data:", data);

  if (data && data.length > 0) {
    const fetchedProduct = data[0];

    product.name = fetchedProduct.Name;
    product.price = fetchedProduct.Price;
    product.image = fetchedProduct.Pic;
    product.description = fetchedProduct.Type;
    product.details = fetchedProduct.details;
  }
};


const addToCart = async () => {
  const url = 'http://localhost/Tunezz/Tunezz/APIs/appfunctions/add_cart.php';
  
  const email = userEmail.value;
  const itemName = product.name;

  const data = {
    cartadd: true,
    email: email,
    item_name: itemName
  };
  console.log("Data to be sent:", data);

  try {
    const response = await axios.post(url, new URLSearchParams(data));
    console.log("Response:", response.data);
  } catch (error) {
    console.error('Error:', error);
  }
};
const submitReview = async () => {
  const url = 'http://localhost/Tunezz/Tunezz/APIs/appfunctions/Add_review.php';
  
  const email = userEmail.value;
  const itemName = product.name;
  const review= newReview.value.content;
  const data = {
    // cartadd: true,
    email: email,
    instrument_name: itemName,
    review: review,
  };
  console.log("Data to be sent:", data);

  try {
    const response = await axios.post(url, new URLSearchParams(data));
    console.log("Response:", response.data);
  } catch (error) {
    console.error('Error:', error);
  }
};
// const submitReview = async () => {
//   try {
//     const response = await axios.post("http://localhost/Tunezz/Tunezz/APIs/appfunctions/Add_review.php", {
//       email: userEmail.value,
//       instrument_name: product.name,
     
//       review: newReview.value.content,
//     });
//     console.log("bro lek",email,instrument_name);
//     console.log("Response:", response.data);
//     reviews.value.push({
//       email:userEmail.value,
//       review: newReview.value.content,
//       instrument_name: product.name
//     });
//     newReview.value.email = "";
//     newReview.value.rating = 0;
//     newReview.value.content = "";
//   } catch (error) {
//     console.error("Error:", error);
//   }
// };

// onMounted(fetchProductData)



// Integration with add_to_cart.php file
const handleAddToCart = () => {
  event.preventDefault();
  addToCart();
};


onMounted(async () => {
  await fetchProductData();
  await fetchUserEmail();
  await fetchReviews();
});
// return {
//       product,
//       userEmail,
//       reviews,
//       newReview,
//       submitReview,
//       addToCart,
//     };


</script>