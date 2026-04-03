<template>
    <div class="grid">
      <WineCard
        v-for="vin in wines"
        :key="vin.id"
        :vin="vin"
        @add-to-cart="addToCart"
      />
    </div>
  </template>

  <script>
  import WineCard from "./WineCard.vue";

  export default {
    components: {
      WineCard,
    },

    props: {
      wines: Array,
    },
    data() {},
    methods: {
      addToCart(vin) {
        this.$emit("add-to-cart", vin);
      },
    },
  };
  </script>
