<template>
  <div class="site-wrapper overflow-hidden ">
      <LandingHeader />
      <slot />
      <LandingFooter />
    </div>
</template>
<script setup lang="ts">
import { onBeforeMount, onMounted } from 'vue';
import '../../assets/css/bootstrap.css';
import '../../assets/css/theme.css';
import { LandingFooter, LandingHeader } from '../Components/Landing';

</script>
