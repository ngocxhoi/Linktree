<template>
  <div>
    <input
      :type="inputType"
      :id="placeholder"
      :placeholder="placeholder"
      :maxlength="String(max)"
      class="w-full bg-[#eff0eb] text-gray-800 border-2 text-sm border-[#eff0eb] rounded-xl py-3.5 px-3 placeholder-gray-500 focus:outline-none"
      @focus="isFocused = true"
      @blur="isFocused = false"
      :class="{ 'border-gray-900': isFocused }"
      v-model="inputComputed"
      autocomplete="off"
    />

    <span v-if="error" class="text-red-400 mx-3 text-sm font-semibold">
      {{ error }}
    </span>
  </div>
</template>

<script lang="ts" setup>
const emits = defineEmits(["update:input"]);
const props = defineProps([
  "placeholder",
  "inputType",
  "max",
  "input",
  "error",
]);
const { inputType, placeholder, max, input, error } = toRefs(props);

const isFocused = ref(false);

const inputComputed = computed({
  get: () => input?.value,
  set: (val) => emits("update:input", val),
});
</script>
