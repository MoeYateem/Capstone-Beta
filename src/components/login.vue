<template>
  <div class="relative h-[90vh]">
    <!-- Background gradient overlay -->
    <div
      class="absolute inset-0 bg-gradient-to-r from-black to-transparent z-10"
    ></div>
    <!-- Background image -->
    <img
      src="../assets/loginBack.jpg"
      alt="Background Image"
      class="absolute inset-0 object-cover w-full h-full opacity-50"
    />
    <!-- Form container -->
    <div class="formC flex items-center justify-center h-full w-1/2">
      <div class="w-full h-full z-20">
        <!-- Form card -->
        <div
          class="form-card flex justify-center items-center shadow-lg rounded-lg overflow-hidden h-full w-[75%]"
        >
          <div class="px-10 w-full">
            <h2 class="text-4xl font-bold text-white mb-4">Welcome Back!</h2>
            <p class="text-white">Log in to your account</p>
            <!-- Login form -->
            <form @submit.prevent="login" class="mt-8">
              <div class="mb-6">
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
              <div class="mb-6">
                <label for="password" class="text-lg font-semibold text-white"
                  >Password</label
                >
                <div class="relative">
                  <input
                    v-model="password"
                    id="password"
                    :type="showPassword ? 'text' : 'password'"
                    required
                    class="mt-2 block w-full rounded-md bg-gray-100 bg-opacity-70 border-transparent focus:border-primary focus:bg-white focus:ring-0 px-4 py-3 pr-10 text-lg"
                  />
                  <button
                    v-if="password"
                    class="absolute top-2 right-2 text-gray-500 focus:outline-none"
                    @click="togglePasswordVisibility"
                  >
                    <i v-show="showPassword" class="fas fa-eye"></i>
                    <i v-show="!showPassword" class="fas fa-eye-slash"></i>
                  </button>
                </div>
              </div>

              <div class="flex items-center justify-center sm:justify-between">
                <button
                  type="submit"
                  class="w-full sm:w-auto px-8 py-4 bg-primary text-white font-semibold rounded-md hover:bg-primary/80 active:translate-y-0.5 transition-all duration-200 ease-in-out text-lg"
                >
                  Log In
                </button>
                <a
                  href="#"
                  class="text-primary font-semibold hover:underline text-lg mt-4 sm:mt-0"
                  @click="toggleForgotPasswordForm"
                  >Forgot Password?</a
                >
              </div>
            </form>
            <ForgotPasswordForm
              v-if="showForgotPasswordForm"
              @close="hideForgotPasswordModal"
            />
            <!-- Sign up link -->
            <div class="mt-10 text-center">
              <p class="text-lg text-white">
                Don't have an account?

                <RouterLink
                  to="/signup"
                  class="text-primary font-semibold hover:underline"
                  >Sign up</RouterLink
                >
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

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

<script>
import ForgotPasswordForm from "./forgotPassword.vue";
import axios from "axios";

export default {
  components:{
    ForgotPasswordForm,
  },
  data() {
    return {
      email: "",
      password: "",
      showPassword:false,
      showForgotPasswordForm: false,
    };
  },
  methods: {
    togglePasswordVisibility(){
      this.showPassword = !this.showPassword;
    },
    hideForgotPasswordModal() {
      this.showForgotPasswordForm = false;
    },
    toggleForgotPasswordForm() {
      this.showForgotPasswordForm = !this.showForgotPasswordForm;
    },
    async login() {
      try {
        const response = await axios.post("http://localhost/Tunezz/Tunezz/APIs/appfunctions/login.php", {
          email: this.email,
          password: this.password,
        });

        if (response.data[0].Message === "Successful login!") {
          localStorage.setItem("session_id", response.data[0].session_id);
          alert("Login successful!");
          window.location.href = "/";
        } else {
          alert("Wrong credentials. Please try again.");
        }
      } catch (error) {
        console.error("An error occurred during login:", error);
        alert("An error occurred. Please try again.");
      }
    },
  },
};
</script>

