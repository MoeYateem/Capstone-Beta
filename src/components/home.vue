<template>
  <categories />
  <newsletter />
  <contactUs />
</template>

<script>
import ContactUs from "./contactUs.vue";
import categories from "./categories.vue";
import newsletter from "./newsletter.vue";
import axios from "axios";

export default {
  components: {
    ContactUs,
    categories,
    newsletter,
  },
  data() {
    return {
      email: null,
    };
  },
  mounted() {
    this.fetchUserEmail();
  },
  methods: {
    fetchUserEmail() {
  axios.get("http://localhost/Tunezz/Tunezz/APIs/appfunctions/session.php", {
    headers: {
      "Session-ID": localStorage.getItem("session_id") // Include the session ID in the headers
    }
  })
  .then((response) => {
    this.email = response.data;
    console.log("User email:", this.email);
  })
  .catch((error) => {
    console.error("Error:", error);
  });
},
  },
};
</script>
