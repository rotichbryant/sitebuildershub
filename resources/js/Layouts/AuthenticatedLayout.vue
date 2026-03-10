<template>
  <div>
    <Sidebar />
    <div class="wrapper d-flex flex-column min-vh-100">
      <Header />
      <div class="body flex-grow-1 px-4 py-2">
        <CContainer class="px-0" fluid>
          <slot />
        </CContainer>
      </div>
    </div>
  </div>
</template>
<script setup lang="ts">
import '../../scss/app.scss';
import { ref } from 'vue';
import {Header,Sidebar} from '../Components/Dashboard'
</script>
