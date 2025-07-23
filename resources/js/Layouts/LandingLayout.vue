<template>
  <div class="site-wrapper overflow-hidden bg-light">
      <LandingHeader 
        :modals="$data.modals"
        @update:modals="$data.modals = $event"
      />
      <slot />
      <LandingFooter />
      <Login
        :modals="$data.modals"
        @update:modals="$data.modals = $event"
        v-if="isEmpty(auth_user)"
      />
      <SignUp
        :modals="$data.modals"
        @update:modals="$data.modals = $event"
        v-if="isEmpty(auth_user)"
      />      
    </div>
</template>
<script setup lang="ts">
import { computed, reactive, watch } from 'vue';
import { LandingFooter, LandingHeader } from '../Components/Landing';
import { Login, SignUp } from '../Components/Landing/Modals';
import { usePage } from '@inertiajs/vue3';
import { isEmpty } from 'lodash';

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
  }
});

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
