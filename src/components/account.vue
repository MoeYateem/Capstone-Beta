<template>
    <div class="flex justify-center items-center flex-col w-[80%] mx-auto p-6">
      <div class="border-[3px] p-10 rounded-lg bg-white border-primary w-[80%]">
        <div class="px-4 sm:px-0">
          <h3 class="text-2xl leading-7 text-secondary font-extrabold">
            Account Information
          </h3>
        </div>
        <div class="mt-6 border-t border-gray-900">
          <dl class="divide-y divide-gray-900">
            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
              <dt class="text-sm leading-6 text-secondary font-bold">
                Full name
              </dt>
              <dd class="mt-1 text-sm leading-6 text-black sm:col-span-2 sm:mt-0">
                {{ fullName }}
              </dd>
            </div>
  
            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
              <dt class="text-sm leading-6 text-secondary font-bold">
                Email address
              </dt>
              <dd class="mt-1 text-sm leading-6 text-black sm:col-span-2 sm:mt-0">
                {{ emailAddress }}
              </dd>
            </div>
  
            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
              <dt class="text-sm leading-6 text-secondary font-bold">
                Credit Cards
              </dt>
              <dd class="mt-1 text-sm leading-6 text-black sm:col-span-2 sm:mt-0">
                <ul>
                  <li v-for="card in creditCards" :key="card.id" class="mb-2">
                    <div>
                      <span class="font-semibold">Name:</span> {{ card.name }}
                    </div>
                    <div>
                      <span class="font-semibold">Expiry Date:</span>
                      {{ card.expiryDate }}
                    </div>
                    <div>
                      <span class="font-semibold">SRN:</span> {{ card.srn }}
                    </div>
                    <div>
                      <span class="font-semibold">Card Number:</span>
                      {{ card.ccNumber }}
                      <span
                        class="ml-2 cursor-pointer"
                        @click="removeCard(card.id)"
                      >
                        <i class="fas fa-times text-red-500"></i>
                      </span>
                    </div>
                  </li>
                </ul>
                <button
                  type="button"
                  @click="openAddCardForm = true"
                  class="mt-2 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary"
                >
                  Add Card
                </button>
              </dd>
  
              <!-- Popup Form -->
              <div
                v-if="openAddCardForm"
                class="fixed inset-0 flex items-center justify-center z-50"
              >
                <div class="bg-white rounded-lg shadow-lg p-6">
                  <h3 class="text-lg font-medium text-gray-900 mb-4">
                    Add Credit Card
                  </h3>
                  <form @submit.prevent="submitForm">
                    <div class="mb-4">
                      <label
                        for="cardName"
                        class="block text-sm font-medium text-gray-700"
                        >Name</label
                      >
                      <input
                        v-model="newCard.name"
                        id="cardName"
                        type="text"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary focus:border-primary"
                        required
                      />
                    </div>
                    <div class="mb-4">
                      <label
                        for="expiryDate"
                        class="block text-sm font-medium text-gray-700"
                        >Expiry Date</label
                      >
                      <input
                        required
                        v-model="newCard.expiryDate"
                        id="expiryDate"
                        type="date"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary focus:border-primary"
                      />
                    </div>
                    <div class="mb-4">
                      <label
                        for="srn"
                        class="block text-sm font-medium text-gray-700"
                        >SRN (3 digits only)</label
                      >
                      <input
                        required
                        type="text"
                        v-model="newCard.srn"
                        maxlength="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary focus:border-primary"
                        @input="restrictNonNumeric"
                      />
                    </div>
                    <div class="mb-4">
                      <label
                        for="cardNumber"
                        class="block text-sm font-medium text-gray-700"
                        >Card Number (16 digits only)</label
                      >
                      <input
                        v-model="newCard.ccNumber"
                        id="cardNumber"
                        type="text"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary focus:border-primary"
                        @input="handleCreditCardInput"
                        required
                      />
                    </div>
                    <div class="flex justify-end">
                      <button
                        type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary"
                      >
                        Save
                      </button>
                      <button
                        type="button"
                        @click="openAddCardForm = false"
                        class="ml-2 inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary"
                      >
                        Cancel
                      </button>
                    </div>
                    <!-- ERROR MESSAGE -->
                    <div
                      v-if="errorMessage"
                      class="fixed inset-0 flex items-center justify-center z-50"
                    >
                      <div class="bg-white rounded-lg shadow-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                          Error
                        </h3>
                        <p class="text-sm text-red-600">{{ errorMessage }}</p>
                        <button
                          type="button"
                          @click="errorMessage = ''"
                          class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                        >
                          Close
                        </button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
  
            <div
              v-if="showConfirmation"
              class="fixed inset-0 flex items-center justify-center z-50"
            >
              <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                  Confirmation
                </h3>
                <p class="text-sm text-gray-800 mb-4">
                  Are you sure you want to remove this item?
                </p>
                <div class="flex justify-end">
                  <button
                    type="button"
                    @click="removeConfirmed"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                  >
                    Remove
                  </button>
                  <button
                    type="button"
                    @click="cancelRemoval"
                    class="ml-2 inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary"
                  >
                    Cancel
                  </button>
                </div>
              </div>
            </div>
  
            <!-- ... previous template code ... -->
  
            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
              <dt class="text-sm leading-6 text-secondary font-bold">
                Addresses
              </dt>
              <dd class="mt-1 text-sm leading-6 text-black sm:col-span-2 sm:mt-0">
                <ul>
                  <li v-for="address in addresses" :key="address.id" class="mb-2">
                    <div>
                      <span class="font-semibold">Postal Code:</span>
                      {{ address.postalCode }}
                    </div>
                    <div>
                      <span class="font-semibold">Address:</span>
                      {{ address.address }}
                      <span
                        class="ml-2 cursor-pointer"
                        @click="confirmAddressRemoval(address.id)"
                      >
                        <i class="fas fa-times text-red-500"></i>
                      </span>
                    </div>
                  </li>
                </ul>
  
                <button
                  type="button"
                  @click="openAddAddressForm = true"
                  class="mt-2 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary"
                >
                  Add Address
                </button>
              </dd>
  
              <!-- Address Form -->
              <div
                v-if="openAddAddressForm"
                class="fixed inset-0 flex items-center justify-center z-50"
              >
                <div class="bg-white rounded-lg shadow-lg p-6">
                  <h3 class="text-lg font-medium text-gray-900 mb-4">
                    Add Address
                  </h3>
                  <form @submit.prevent="submitAddressForm">
                    <div class="mb-4">
                      <label
                        for="postalCode"
                        class="block text-sm font-medium text-gray-700"
                      >
                        Postal Code (4 digits only)
                      </label>
                      <input
                        v-model="newAddress.postalCode"
                        id="postalCode"
                        type="text"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary focus:border-primary"
                        required
                        maxlength="4"
                        @input="restrictNonNumericPostal"
                      />
                    </div>
                    <div class="mb-4">
                      <label
                        for="address"
                        class="block text-sm font-medium text-gray-700"
                      >
                        Address
                      </label>
                      <textarea
                        v-model="newAddress.address"
                        id="address"
                        rows="4"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary focus:border-primary"
                        required
                      ></textarea>
                    </div>
                    <div class="flex justify-end">
                      <button
                        type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary"
                      >
                        Save
                      </button>
                      <button
                        type="button"
                        @click="openAddAddressForm = false"
                        class="ml-2 inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary"
                      >
                        Cancel
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
  
            <!-- Error Message -->
            <div
              v-if="addressErrorMessage"
              class="fixed inset-0 flex items-center justify-center z-50"
            >
              <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Error</h3>
                <p class="text-sm text-red-600">{{ addressErrorMessage }}</p>
                <button
                  type="button"
                  @click="addressErrorMessage = ''"
                  class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                >
                  Close
                </button>
              </div>
            </div>
  
            <!-- Address Removal Confirmation Dialog -->
            <div
              v-if="showAddressConfirmation"
              class="fixed inset-0 flex items-center justify-center z-50"
            >
              <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                  Confirmation
                </h3>
                <p class="text-sm text-gray-800 mb-4">
                  Are you sure you want to remove this address?
                </p>
                <div class="flex justify-end">
                  <button
                    type="button"
                    @click="removeAddressConfirmed"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                  >
                    Remove
                  </button>
                  <button
                    type="button"
                    @click="cancelAddressRemoval"
                    class="ml-2 inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary"
                  >
                    Cancel
                  </button>
                </div>
              </div>
            </div>
          </dl>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        showAddressConfirmation: false,
        addressToRemove: null,
        showConfirmation: false,
        itemToRemove: null,
        fullName: "Margot Foster",
        emailAddress: "emailAddress@example.com",
        addresses: [
          {
            id: 1,
            postalCode: "1234",
            address: "123 Main St",
          },
          {
            id: 2,
            postalCode: "5678",
            address: "456 Elm St",
          },
        ],
        newAddress: { postalCode: "", address: "" },
        openAddAddressForm: false,
        addressErrorMessage: "", // Error message to display
  
        errorMessage: "", // Error message to display
        creditCards: [
          {
            id: 1,
            name: "John Doe",
            expiryDate: "12/23",
            srn: "123",
            ccNumber: "1234567890123456",
          },
          {
            id: 2,
            name: "Jane Smith",
            expiryDate: "10/24",
            srn: "456",
            ccNumber: "9876543210987654",
          },
        ],
        newCard: { name: "", expiryDate: "", srn: "", ccNumber: "" },
        openAddCardForm: false,
      };
    },
    methods: {
      confirmAddressRemoval(id) {
        this.addressToRemove = id;
        this.showAddressConfirmation = true;
      },
      removeAddressConfirmed() {
        // Remove the address from the list
        this.removeAddress(this.addressToRemove);
  
        // Reset the confirmation state
        this.showAddressConfirmation = false;
        this.addressToRemove = null;
      },
  
      removeAddress(id) {
        this.addresses = this.addresses.filter((address) => address.id !== id);
      },
      cancelAddressRemoval() {
        // Reset the confirmation state
        this.showAddressConfirmation = false;
        this.addressToRemove = null;
      },
  
      confirmCardRemoval(id) {
        this.itemToRemove = id;
        this.showConfirmation = true;
      },
  
      removeConfirmed() {
        // Remove the item from the list
        this.creditCards = this.creditCards.filter(
          (card) => card.id !== this.itemToRemove
        );
  
        // Reset the confirmation state
        this.showConfirmation = false;
        this.itemToRemove = null;
      },
  
      cancelRemoval() {
        // Reset the confirmation state
        this.showConfirmation = false;
        this.itemToRemove = null;
      },
      removeCard(id) {
        this.itemToRemove = id;
        this.showConfirmation = true;
      },
  
      submitAddressForm(event) {
        event.preventDefault();
  
        // Reset the error message
        this.addressErrorMessage = "";
  
        // Validate the postal code and address fields
        if (
          this.newAddress.postalCode &&
          /^\d{4}$/.test(this.newAddress.postalCode) &&
          this.newAddress.address
        ) {
          // Form is valid, submit it
          this.addAddress();
        } else {
          // Form is not valid, set the error message
          this.addressErrorMessage = "Please fill in all fields correctly.";
        }
      },
  
      addAddress() {
        // Add validation and processing logic for the new address
        // For simplicity, we're directly pushing the new address to the list here
        this.addresses.push({
          id: Date.now(),
          postalCode: this.newAddress.postalCode,
          address: this.newAddress.address,
        });
  
        // Reset the form fields
        this.newAddress.postalCode = "";
        this.newAddress.address = "";
  
        // Close the add address form
        this.openAddAddressForm = false;
      },
      submitForm(event) {
        event.preventDefault();
  
        // Reset the error message
        this.errorMessage = "";
  
        // Validate all fields before submitting the form
        if (
          this.newCard.name &&
          this.newCard.expiryDate &&
          this.newCard.srn.length === 3 &&
          /^\d+$/.test(this.newCard.srn) &&
          this.newCard.ccNumber.length === 19 // including spaces
        ) {
          // Form is valid, submit it
          this.addCard(); // Call the addCard method to process the new card
        } else {
          // Form is not valid, set the error message
          this.errorMessage = "Please fill in all fields correctly.";
        }
      },
  
      handleCreditCardInput(event) {
        this.restrictCreditCardNumber(event);
        this.formatCreditCardNumber();
      },
      formatCreditCardNumber() {
        // Add spaces between every 4 digits
        this.newCard.ccNumber = this.newCard.ccNumber.replace(
          /(\d{4})(?=\d)/g,
          "$1 "
        );
      },
      addCard() {
        // Add validation and processing logic for the new card
        // For simplicity, we're directly pushing the new card to the list here
        this.creditCards.push({
          id: Date.now(),
          name: this.newCard.name,
          expiryDate: this.newCard.expiryDate,
          srn: this.newCard.srn,
          ccNumber: this.newCard.ccNumber,
        });
  
        // Reset the form fields
        this.newCard.name = "";
        this.newCard.expiryDate = "";
        this.newCard.srn = "";
        this.newCard.ccNumber = "";
  
        // Close the add card form
        this.openAddCardForm = false;
      },
      restrictNonNumeric(event) {
        const input = event.target;
        input.value = input.value.replace(/\D/g, ""); // Remove non-numeric characters
  
        // Limit the input length to 3 digits
        if (input.value.length > 3) {
          input.value = input.value.slice(0, 3);
        }
      },
      restrictNonNumericPostal(event) {
        const input = event.target;
        input.value = input.value.replace(/\D/g, ""); // Remove non-numeric characters
  
        // Limit the input length to 4 digits
        if (input.value.length > 4) {
          input.value = input.value.slice(0, 4);
        }
      },
      restrictCreditCardNumber() {
        // Remove non-numeric characters from the input
        this.newCard.ccNumber = this.newCard.ccNumber.replace(/\D/g, "");
  
        // Limit the input to 16 digits
        if (this.newCard.ccNumber.length > 16) {
          this.newCard.ccNumber = this.newCard.ccNumber.slice(0, 16);
        }
      },
    },
  };
  </script>