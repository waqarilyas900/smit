<template>
  <!-- <div>
    <h6 class="font-semibold text-xl">Product Description</h6>

    <p class="mt-3"> {{description}}
    </p>
  </div> -->
</template>

<script>
export default {
  props: {
    description: {
      type: String,
      default: "No description found!"
    }
  }
};
</script>

<style lang="scss" scoped>
</style>
