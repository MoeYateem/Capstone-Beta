
<template>
  <div class="relative h-full">
    <!-- Background gradient overlay -->
    <div
      class="absolute inset-0 bg-gradient-to-r from-black to-primary/20 z-10"
    ></div>
    <!-- Background image -->
    <img
      src="../assets/signBack.jpg"
      alt="Background Image"
      class="absolute inset-0 object-cover w-full h-full opacity-50"
    />
    <!-- Form container -->
    <div class="formC flex items-center justify-center h-[90vh] w-2/3">
      <div class="w-full h-full z-20">
        <!-- Form card -->
        <div
          class="form-card flex justify-center items-center shadow-lg rounded-lg overflow-hidden w-[75%] mt-10"
        >
          <div class="px-10 w-full h-full">
            <h2 class="text-4xl font-bold text-white mb-4">Register</h2>
            <!-- Registration form -->
            <form @submit.prevent="register" class="mt-8">
              <div class="grid grid-cols-2 gap-6">
                <div class="col-span-2">
                  <label for="email" class="text-lg font-semibold text-white"
                    >Email</label
                  >
                  <input
                    v-model="email"
                    id="email"
                    type="email"
                    required
                    class="mt-2 block w-full rounded-md bg-gray-100 bg-opacity-70 border-transparent focus:border-primary focus:bg-white focus:ring-0 px-4 py-3 text-lg"
                  />
                </div>
                <div>
                  <label for="fname" class="text-lg font-semibold text-white"
                    >First name</label
                  >
                  <input
                    v-model="fname"
                    id="fname"
                    type="text"
                    required
                    inputmode="text"
                    class="mt-2 block w-full rounded-md bg-gray-100 bg-opacity-70 border-transparent focus:border-primary focus:bg-white focus:ring-0 px-4 py-3 text-lg"
                  />
                </div>
                <div>
                  <label for="lname" class="text-lg font-semibold text-white"
                    >Last Name</label
                  >
                  <input
                    v-model="lname"
                    id="lname"
                    type="text"
                    required
                    inputmode="text"
                    class="mt-2 block w-full rounded-md bg-gray-100 bg-opacity-70 border-transparent focus:border-primary focus:bg-white focus:ring-0 px-4 py-3 text-lg"
                  />
                </div>
                <div class="col-span-2 flex items-center relative">
                  <div
                  class="absolute right-[-5vw] top-[70%] transform -translate-y-1/2"
                >
                  <svg
                    v-if="
                      password &&
                      confirmPassword &&
                      password === confirmPassword
                    "
                    class="w-6 h-6 text-green-500"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M5 13l4 4L19 7"
                    ></path>
                  </svg>
                  <svg
                    v-else-if="password && confirmPassword"
                    class="w-6 h-6 text-red-500"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M6 18L18 6M6 6l12 12"
                    ></path>
                  </svg>
                </div>
                  <div class="w-1/2 mr-4">
                    <label
                      for="password"
                      class="text-lg font-semibold text-white"
                      >Password</label
                    >
                    <input
                      v-model="password"
                      id="password"
                      type="password"
                      required
                      class="mt-2 block w-full rounded-md bg-gray-100 bg-opacity-70 border-transparent focus:border-primary focus:bg-white focus:ring-0 px-4 py-3 text-lg"
                    />
                  </div>
                  <div class="w-1/2">
                    <label
                      for="confirmPassword"
                      class="text-lg font-semibold text-white"
                      >Confirm Password</label
                    >
                    <input
                      v-model="confirmPassword"
                      id="confirmPassword"
                      type="password"
                      required
                      class="mt-2 block w-full rounded-md bg-gray-100 bg-opacity-70 border-transparent focus:border-primary focus:bg-white focus:ring-0 px-4 py-3 text-lg"
                    />
                  </div>
                </div>
                
              </div>

              <div
                class="flex items-center  sm:justify-between mt-6 flex-col sm:flex-row"
              >
                <button
                  type="submit"
                  name="submit"
                  class="w-full sm:w-auto px-8 py-4 bg-primary text-white font-semibold rounded-md hover:bg-primary/80 active:translate-y-0.5 transition-all duration-200 ease-in-out text-lg"
                >
                  Register
                </button>
              </div>
            </form>
            <!-- Sign in link -->
            <div class="mt-10 text-center">
              <p class="text-lg text-white">
                Already have an account?
                <router-link
                  to="/login"
                  class="text-primary font-semibold hover:underline"
                >
                  LogIn
                </router-link>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      fname: "",
      lname: "",
      email: "",
      password: "",
      confirmPassword: "",
    };
  },
  methods: {
    // validatePhoneNumber(event) {
    //   // ...
    // },
    async register() {
      if (this.password !== this.confirmPassword) {
        alert("Passwords do not match.");
        return;
      }

      try {
        const response = await axios.post("http://localhost/Tunezz/Tunezz/APIs/appfunctions/register.php", {
          fname: this.fname,
          lname: this.lname,
          email: this.email,
          password: this.password,
          // Remove confirmPassword from the request payload
        });

        if (response.data.Message === "Email already exists.") {
          alert("Email already exists. Please use a different email address.");
        } else if (response.data.Message === "You have successfully registered!") {
          alert("Registration successful!");
          window.location.href = "/login";
          // Redirect to the login page or perform any other necessary action
        } else {
          alert("Failed to register. Please try again later.");
        }
      } catch (error) {
        console.error("An error occurred during registration:", error);
        alert("An error occurred. Please try again.");
      }
    },
  },
};
</script>



<style scoped>
@media screen and (max-width: 1024px) {
  .formC {
    width: 100%;
  }
  .form-card {
    width: 100%;
  }
}
</style>
