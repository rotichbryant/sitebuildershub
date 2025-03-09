<template>
<!-- Header Area -->
<header class="site-header site-header--menu-right bg-default py-7 py-lg-0 site-header--absolute site-header--sticky">
  <div class="container">
    <nav class="navbar site-navbar offcanvas-active navbar-expand-lg  px-0 py-0">
      <!-- Brand Logo-->
      <div class="brand-logo">
        <a href="./index.html">
          <!-- light version logo (logo must be black)-->
          <img src="../../../image/logo-main-black.png" alt="" class="light-version-logo default-logo">
          <!-- Dark version logo (logo must be White)-->
          <img src="../../../image/logo-main-white.png" alt="" class="dark-version-logo">
        </a>
      </div>
      <div class="collapse navbar-collapse" id="mobile-menu">
        <div class="navbar-nav-wrapper">
          <ul class="navbar-nav main-menu">
            <li class="nav-item">
              <a class="nav-link" :href="route('landing.home')">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" :href="route('landing.postings')">Postings</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" :href="route('landing.aboutus')">About Us</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" :href="route('landing.contactus')">Contact Us</a>
            </li>
          </ul>
        </div>
        <button class="d-block d-lg-none offcanvas-btn-close focus-reset" type="button" data-toggle="collapse" data-target="#mobile-menu" aria-controls="mobile-menu" aria-expanded="true" aria-label="Toggle navigation">
          <i class="gr-cross-icon"></i>
        </button>
      </div>
      <div class="header-btns header-btn-devider ml-auto pr-2 ml-lg-6 d-none d-xs-flex" v-if="isEmpty(auth_user)">
        <a class="btn btn-transparent text-uppercase font-size-3 heading-default-color focus-reset" href="#" @click="$data.modals.login = true">
          Log in
        </a>
        <a class="btn btn-primary text-uppercase font-size-3" href="#" @click="$data.modals.signup = true">
          Sign up
        </a>
      </div>
      <!-- Mobile Menu Hamburger-->
      <button class="navbar-toggler btn-close-off-canvas  hamburger-icon border-0" type="button" data-toggle="collapse" data-target="#mobile-menu" aria-controls="mobile-menu" aria-expanded="false" aria-label="Toggle navigation">
        <!-- <i class="icon icon-simple-remove icon-close"></i> -->
        <span class="hamburger hamburger--squeeze js-hamburger">
          <span class="hamburger-box">
            <span class="hamburger-inner"></span>
          </span>
        </span>
      </button>
      <!--/.Mobile Menu Hamburger Ends-->
    </nav>
  </div>
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
</header>
</template>
<script setup>
import { computed, onMounted, ref, reactive, watch } from 'vue'
import { useColorModes } from '@coreui/vue'
import { Login, SignUp } from './Modals'
import { usePage } from '@inertiajs/vue3'
import { isEmpty } from 'lodash'

const headerClassNames = ref('p-0')
const { colorMode, setColorMode } = useColorModes('coreui-free-vue-admin-template-theme')

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
 * The computed property for the authenticated user.
 * 
 * @return {Object} - The authenticated user object.
 */
const auth_user = computed( () => usePage().props.auth.user )

onMounted(() => {
  document.addEventListener('scroll', () => {
    if (document.documentElement.scrollTop > 0) {
      headerClassNames.value = 'p-0 shadow-sm'
    } else {
      headerClassNames.value = 'p-0'
    }
  })
})

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
