<script setup>
import { ref, reactive, onMounted } from "vue";

import {
  Dialog,
  DialogPanel,
  DialogTitle,
  TransitionChild,
  TransitionRoot,
} from "@headlessui/vue";

const cartOpen = ref(false);
const products = reactive([]);

const fetchCartData = async (email) => {
  try {
    const response = await fetch(
      `http://localhost/Tunezz/Tunezz/APIs/appfunctions/get_cart.php?email=${email}`
    );
    const data = await response.json();
    console.log(data);
    products.value = data.map((item) => ({
      ...item,
      imageSrc: "http://localhost/Tunezz/Tunezz/src/assets/" + item.pic, // Replace with actual image path
      imageAlt: 'Product image', // Replace with actual image description
      // color: 'Color', // Replace with actual color attribute if available
      id: item.name, // Replace with a unique identifier if available
      // href: 'path/to/product', // Replace with actual product link
      quantity: 1, // Add a default quantity, or use actual value if available
    }));
    console.log("lek",products);
  } catch (error) {
    console.error('Error fetching cart data:', error);
  }
};

onMounted(() => {
  fetchCartData('mohamad.yateem@lau.edu'); // Replace with the user's email
});

const incrementQuantity = (product) => {
  product.quantity++;
};

const decrementQuantity = (product) => {
  if (product.quantity > 1) {
    product.quantity--;
  }
};

const calculateTotal = () => {
  let total = 0;
  products.forEach((product) => {
    total += parseFloat(product.price.replace('$', '')) * product.quantity;
  });
  return '$' + total.toFixed(2);
};

const removeProduct = (product) => {
  products.splice(products.indexOf(product), 1);
};
</script>

<script>
import {
  Disclosure,
  DisclosureButton,
  DisclosurePanel,
  Menu,
  MenuButton,
  MenuItem,
  MenuItems,
} from "@headlessui/vue";
import {
  Bars3Icon,
  XMarkIcon,
  ShoppingCartIcon,
  HeartIcon,
} from "@heroicons/vue/24/outline";

const navigation = [
  { name: "Home", href: "/", current: true },
  { name: "Products", href: "/productPage", current: false },
  { name: "Contact Us", href: "/login", current: false },
  { name: "About Us", href: "#", current: false },
];

const slides = [
  "../assets/carousel1.jpg",
  "../assets/carousel2.jpg",
  "../assets/carousel3.jpg",
];
</script>

<template>
  <Disclosure as="nav" class="bg-primary" v-slot="{ open }">
    <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
      <div class="relative flex h-[10vh] items-center justify-between">
        <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
          <!-- Mobile menu button-->
          <DisclosureButton
            class="inline-flex items-center justify-center rounded-full p-2 text-white hover:bg-white hover:text-black ease-in-out transition-all duration-200 focus:outline-none"
          >
            <span class="sr-only">Open main menu</span>
            <Bars3Icon v-if="!open" class="block h-6 w-6" aria-hidden="true" />
            <XMarkIcon v-else class="block h-6 w-6" aria-hidden="true" />
          </DisclosureButton>
        </div>
        <div
          class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-between"
        >
          <div class="flex flex-shrink-0 items-center">
            <img
              class="block h-20 w-auto lg:hidden"
              src="../assets/tLOGO.png"
              alt="Your Company"
            />
            <img
              class="hidden h-20 w-auto lg:block"
              src="../assets/tLOGO.png"
              alt="Your Company"
            />
          </div>
          <div class="hidden sm:ml-6 sm:block my-auto mr-52">
            <div class="flex space-x-16">
              <router-link
                v-for="item in navigation"
                :key="item.name"
                :to="item.href"
                :class="[
                  item.current
                    ? 'text-white hover:bg-gray-100 hover:text-black ease-in-out transition-all duration-200 active:translate-y-0.5'
                    : 'text-white hover:bg-gray-100 hover:text-black ease-in-out transition-all duration-200 active:translate-y-0.5',
                  'rounded-md px-3 py-2 text-lg font-medium',
                ]"
                :aria-current="item.current ? 'page' : undefined"
                >{{ item.name }}</router-link
              >
            </div>
          </div>
        </div>
        <div
          class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0"
        >
          <button
            type="button"
            class="rounded-full bg-primary p-1 text-white hover:text-white focus:outline-none"
            @click="cartOpen = true"
          >
            <span class="sr-only">View notifications</span>
            <ShoppingCartIcon
              class="rounded-full bg-primary p-1 text-white hover:text-black hover:bg-white transition-all duration-200 ease-in-out focus:outline-none h-8 w-8"
              aria-hidden="true"
            />
          </button>
          <button
            type="button"
            class="rounded-full bg-primary p-1 text-white hover:text-white focus:outline-none"
          >
            <span class="sr-only">View notifications</span>
            <HeartIcon
              class="rounded-full bg-primary p-1 text-white hover:text-black hover:bg-white transition-all duration-200 ease-in-out focus:outline-none h-8 w-8"
              aria-hidden="true"
            />
          </button>

          <!-- Profile dropdown -->
          <Menu as="div" class="relative ml-3 z-50">
            <div>
              <MenuButton
                class="flex rounded-full bg-primary text-sm focus:outline-none hover:ring-2 hover:ring-white p-1 transition-all duration-200 ease-in-out"
              >
                <span class="sr-only">Open user menu</span>
                <img
                  class="h-8 w-8 rounded-full"
                  src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                  alt=""
                />
              </MenuButton>
            </div>
            <transition
              enter-active-class="transition ease-out duration-100"
              enter-from-class="transform opacity-0 scale-95"
              enter-to-class="transform opacity-100 scale-100"
              leave-active-class="transition ease-in duration-75"
              leave-from-class="transform opacity-100 scale-100"
              leave-to-class="transform opacity-0 scale-95"
            >
              <MenuItems
                class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
              >
                <MenuItem v-slot="{ active }">
                  <a
                    href="#"
                    :class="[
                      active ? 'bg-gray-100' : '',
                      'block px-4 py-2 text-sm text-gray-700',
                    ]"
                    >Your Profile</a
                  >
                </MenuItem>
                <MenuItem v-slot="{ active }">
                  <a
                    href="#"
                    :class="[
                      active ? 'bg-gray-100' : '',
                      'block px-4 py-2 text-sm text-gray-700',
                    ]"
                    >Settings</a
                  >
                </MenuItem>
                <MenuItem v-slot="{ active }">
                  <a
                    href="#"
                    :class="[
                      active ? 'bg-gray-100' : '',
                      'block px-4 py-2 text-sm text-gray-700',
                    ]"
                    >Sign out</a
                  >
                </MenuItem>
              </MenuItems>
            </transition>
          </Menu>
        </div>
      </div>
    </div>

    <DisclosurePanel class="sm:hidden">
      <div class="space-y-1 px-2 pb-3 pt-2">
        <router-link
          v-for="item in navigation"
          :key="item.name"
          :to="item.href"
          :class="[
            item.current
              ? 'text-white hover:bg-gray-100 hover:text-black ease-in-out transition-all duration-200 active:translate-y-0.5 border-b-2 rounded-none'
              : 'text-white hover:bg-gray-100 hover:text-black ease-in-out transition-all duration-200 active:translate-y-0.5 border-b-2 rounded-none',
            'block rounded-md px-3 py-2 text-base font-medium',
          ]"
          :aria-current="item.current ? 'page' : undefined"
          as="button"
          >{{ item.name }}</router-link
        >
      </div>
    </DisclosurePanel>
  </Disclosure>

  <TransitionRoot as="template" :show="cartOpen" class="z-50">
    <Dialog as="div" class="relative z-50" @close="cartOpen = !cartOpen">
      <TransitionChild
        as="template"
        enter="ease-in-out duration-500"
        enter-from="opacity-0"
        enter-to="opacity-100"
        leave="ease-in-out duration-500"
        leave-from="opacity-100"
        leave-to="opacity-0"
      >
        <div
          class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity"
        />
      </TransitionChild>
<!-- cart start -->
      <div class="fixed inset-0 overflow-hidden">
        <div class="absolute inset-0 overflow-hidden">
          <div
            class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10"
          >
            <TransitionChild
              as="template"
              enter="transform transition ease-in-out duration-500 sm:duration-700"
              enter-from="translate-x-full"
              enter-to="translate-x-0"
              leave="transform transition ease-in-out duration-500 sm:duration-700"
              leave-from="translate-x-0"
              leave-to="translate-x-full"
            >
              <DialogPanel class="pointer-events-auto w-screen max-w-md">
                <div
                  class="flex h-full flex-col overflow-y-scroll bg-secondary shadow-xl"
                >
                  <div class="flex-1 overflow-y-auto px-4 py-6 sm:px-6">
                    <div class="flex items-start justify-between">
                      <DialogTitle class="text-lg font-medium text-primary">
                        Shopping cart
                      </DialogTitle>
                      <div class="ml-3 flex h-7 items-center">
                        <button
                          type="button"
                          class="-m-2 p-2 text-gray-400 hover:text-gray-500"
                          @click="cartOpen = false"
                        >
                          <span class="sr-only">Close panel</span>
                          <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                        </button>
                      </div>
                    </div>

                    <div class="mt-8">
                      <div class="flow-root">
                        <ul role="list" class="-my-6 divide-y divide-gray-200">
                          <li
                            v-for="product in products.value"
                            :key="product.id"
                            class="flex py-6"
                          >
                            <div
                              class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-md border border-gray-200"
                            >
                              <img
                                :src="product.imageSrc"
                                :alt="product.imageAlt"
                                class="h-full w-full object-cover object-center"
                              />
                            </div>

                            <div class="ml-4 flex flex-1 flex-col">
                              <div>
                                <div
                                  class="flex justify-between text-base font-medium text-gray-900 border-b border-gray-200 pb-1"
                                >
                                  <!-- <h3>
                                    <a
                                      :href="product.href"
                                      class="text-tertiary hover:underline"
                                    >
                                      {{ product.name }}
                                    </a>
                                  </h3> -->
                                  <p class="ml-4 text-tertiary">
                                    {{ product.price }}
                                  </p>
                                </div>
                                <!-- <p class="mt-1 text-sm text-white">
                                  {{ product.color }}
                                </p> -->
                              </div>
                              <div
                                class="flex flex-1 items-end justify-between text-sm"
                              >
                                <p class="text-white">
                                  Qty
                                  <button
                                    @click="incrementQuantity(product)"
                                    class="px-2 py-1 mx-1 text-sm font -medium text-white bg-primary rounded-md hover:bg-primary/80 active:scale-95 transition-all duration-200 ease-in-out"
                                  >
                                    +
                                  </button>
                                  {{ product.quantity }}  
                                  <button
                                    @click="decrementQuantity(product)"
                                    class="px-2 py-1 mx-1 text-sm font-medium text-white bg-primary rounded-md hover:bg-primary/80 active:scale-95 transition-all"
                                  >
                                    -
                                  </button>
                                </p>

                                <div class="flex">
                                  <button
                                    type="button"
                                    class="font-medium text-primary hover:text-indigo-500"
                                    @click="removeProduct(product)"
                                  >
                                    Remove
                                  </button>
                                </div>
                              </div>
                            </div>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>

                  <div class="border-t border-gray-200 px-4 py-6 sm:px-6">
                    <div
                      class="flex justify-between text-base font-medium text-primary"
                    >
                      <p>Subtotal</p>
                      <p>{{ calculateTotal() }}</p>
                    </div>
                    <p class="mt-0.5 text-sm text-tertiary">
                      Shipping and taxes calculated at checkout.
                    </p>
                    <div class="mt-6">
                      <a
                        href="#"
                        class="flex items-center justify-center rounded-md border border-transparent bg-primary px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-primary/80 active:translate-y-0.5 transition-all duration-200 ease-in-out"
                      >
                        Checkout
                      </a>
                    </div>
                  </div>
                </div>
              </DialogPanel>
            </TransitionChild>
          </div>
        </div>
      </div>
      <!-- cart end -->
    </Dialog>
  </TransitionRoot>
</template>
