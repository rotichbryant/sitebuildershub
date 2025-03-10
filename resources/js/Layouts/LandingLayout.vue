<template>
  <div class="site-wrapper overflow-hidden ">
      <LandingHeader />
      <slot />
      <LandingFooter />
    </div>
</template>
<script setup lang="ts">
import { LandingFooter, LandingHeader } from '../Components/Landing';
</script>
