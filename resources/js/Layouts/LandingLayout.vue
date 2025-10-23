<template>
  <div class="site-wrapper bg-light container-fluid px-0">

      <LandingHeader 
        :modals="$data.modals"
        @update:modals="$data.modals = $event"
      >
        <template #breadcrumb>
          <slot name="breadcrumb"></slot>
        </template>
      </LandingHeader>
      <slot />
      <LandingFooter />
      <Login
        :modals="$data.modals"
        @update:modals="$data.modals = $event"
        v-if="isEmpty(auth_user)"
        :placements="login_placements"
      />
      <SignUp
        :modals="$data.modals"
        @update:modals="$data.modals = $event"
        v-if="isEmpty(auth_user)"
        :placements="signup_placements"
      />      
    </div>
</template>
<script setup lang="ts">
import { computed, reactive, watch, onMounted } from 'vue';
import { LandingFooter, LandingHeader } from '../Components/Landing';
import { Login, SignUp } from '../Components/Landing/Modals';
import { usePage } from '@inertiajs/vue3';
import { isEmpty } from 'lodash';
import axios from 'axios';

/**
 * The computed property for the authenticated user.
 * 
 * @return {Object} - The authenticated user object.
 */
const auth_user = computed( () => usePage().props.auth.user )

/**
 * The reactive data object.
 * 
 * @property {Boolean} visible - Whether the menu is visible or not.
 * @property {Object} modals - The modals object.
 * @property {Boolean} modals.login - Whether the login modal is visible or not.
 * @property {Boolean} modals.signup - Whether the signup modal is visible or not.
 */
const $data = reactive({
  visible: false,
  modals: {
    login: false,
    signup: false
  },
  placements: []
});

const login_placements = computed( () => $data.placements.filter( placement => placement.section === 'login' ) );
const signup_placements = computed( () => $data.placements.filter( placement => placement.section === 'signup' ) );

/**
 * Fetch the header data from the server.
 * 
 * @return {Promise<void>} - A promise that resolves when the data has been fetched.
 */
const fetch = async () => {
  try {
    // Fetch the header data from the server.
    const { data:{ placements } } = await axios.get(route('landing.security'));
    // Set the placements data on the component.
    $data.placements = placements;
  } catch (error) {
    // Log the error to the console.
    console.error('Error fetching data:', error);
  }
}

onMounted(fetch)

/**
 * Watch the signup modal and toggle the login modal
 */
watch( 
 ()      => $data.modals.signup,
 (value) => {
  /**
   * If the signup modal is visible, hide the login modal
   */
  if(value) $data.modals.login = false;
 }  
);

/**
 * Watch the login modal and toggle the signup modal
 */
watch( 
 ()      => $data.modals.login,
 (value) => {
  /**
   * If the login modal is visible, hide the signup modal
   */
  if(value) $data.modals.signup = false;
 }  
)
</script>
