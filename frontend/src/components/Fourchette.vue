<template>
  <li>
    <div class="filter-title" @click="open = !open">
      <strong>{{ label }}</strong>
      <span>{{ open ? "−" : "+" }}</span>
    </div>

    <div v-show="open" class="price-range">
      <div class="slider-container">
        <div class="price-inputs">
          <div class="min-max">
            <label>Minimum</label>
            <input
              type="number"
              v-model.number="range[0]"
              :min="minLimit"
              :max="range[1]"
              class="input-min"
            />
          </div>

          <div class="min-max">
            <label>Maximum</label>
            <input
              type="number"
              v-model.number="range[1]"
              :min="range[0]"
              :max="maxLimit"
              class="input-max"
            />
          </div>
        </div>
        <Slider
          v-model="range"
          :min="minLimit"
          :max="maxLimit"
          :tooltips="false"
        />

        <button @click="apply" class="app-filtre">Appliquer le filtre</button>
      </div>
    </div>
  </li>
</template>

<script>
import Slider from "@vueform/slider";
import "@vueform/slider/themes/default.css";

export default {
  components: { Slider },

  props: {
    modelValue: Object,
    minLimit: Number,
    maxLimit: Number,
    label: {
      type: String,
      default: "Prix",
    },
  },

  emits: ["update:modelValue"],

  data() {
    return {
      open: false,
      range: null,
    };
  },

  watch: {
    modelValue: {
      immediate: true,
      handler(val) {
        if (val && val.min != null && val.max != null) {
          this.range = [Number(val.min), Number(val.max)];
        } else if (!this.range) {
          this.range = [Number(this.minLimit), Number(this.maxLimit)];
        }
      },
    },

    minLimit() {
      this.initRange();
    },

    maxLimit() {
      this.initRange();
    },

    range: {
      deep: true,
      handler(val) {
        if (!val) return;

        let [min, max] = val;

        if (min > max) {
          this.range = [max, min];
        }
      },
    },
  },

  methods: {
    initRange() {
      if (!this.modelValue?.min && !this.modelValue?.max) {
        this.range = [Number(this.minLimit), Number(this.maxLimit)];
      }
    },

    apply() {
      this.$emit("update:modelValue", {
        min: this.range[0],
        max: this.range[1],
      });
    },
  },
};
</script>
