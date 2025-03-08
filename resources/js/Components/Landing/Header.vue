<template>
  <CHeader position="sticky" :class="headerClassNames">
    <CContainer fluid>
      <CNavbar expand="sm" placement="sticky-top">
        <CContainer fluid>
          <CNavbarToggler aria-label="Toggle navigation" aria-expanded={$data.visible} @click="$data.visible = !$data.visible"/>
          <CCollapse class="navbar-collapse" :visible="$data.visible">
            <CNavbarNav>
              <CNavItem>
                <CNavLink href="#" active> Home </CNavLink>
              </CNavItem>
              <CNavItem>
                <CNavLink href="#">Postings</CNavLink>
              </CNavItem>
              <CNavItem>
                <CNavLink href="#">About Us</CNavLink>
              </CNavItem>
              <CNavItem>
                <CNavLink href="#">Contact Us</CNavLink>
              </CNavItem>
            </CNavbarNav>
          </CCollapse>
        </CContainer>
      </CNavbar>
      <CHeaderNav>
        <CNavItem>
          <CNavLink href="#" @click="$data.modals.login = true">Login</CNavLink>
        </CNavItem>
        <CNavItem>
          <CNavLink href="#" @click="$data.modals.signup = true">Sign Up</CNavLink>
        </CNavItem>
        <CDropdown variant="nav-item" placement="bottom-end">
          <CDropdownToggle :caret="false">
            <CIcon v-if="colorMode === 'dark'" icon="cil-moon" size="lg" />
            <CIcon v-else-if="colorMode === 'light'" icon="cil-sun" size="lg" />
            <CIcon v-else icon="cil-contrast" size="lg" />
          </CDropdownToggle>
          <CDropdownMenu>
            <CDropdownItem
              :active="colorMode === 'light'"
              class="d-flex align-items-center"
              component="button"
              type="button"
              @click="setColorMode('light')"
            >
              <CIcon class="me-2" icon="cil-sun" size="lg" /> Light
            </CDropdownItem>
            <CDropdownItem
              :active="colorMode === 'dark'"
              class="d-flex align-items-center"
              component="button"
              type="button"
              @click="setColorMode('dark')"
            >
              <CIcon class="me-2" icon="cil-moon" size="lg" /> Dark
            </CDropdownItem>
            <CDropdownItem
              :active="colorMode === 'auto'"
              class="d-flex align-items-center"
              component="button"
              type="button"
              @click="setColorMode('auto')"
            >
              <CIcon class="me-2" icon="cil-contrast" size="lg" /> Auto
            </CDropdownItem>
          </CDropdownMenu>
        </CDropdown>
        <Account />
      </CHeaderNav>
      <Login
        :show="$data.modals.login"
        @update:modal="$data.modals.login = $event"
      />
      <SignUp
        :show="$data.modals.signup"
        @update:modal="$data.modals.signup = $event"
      />
    </CContainer>
  </CHeader>
</template>
<script setup>
import { onMounted, ref, reactive } from 'vue'
import { useColorModes } from '@coreui/vue'
import { Login, SignUp } from './Modals'


// import AppBreadcrumb from './AppBreadcrumb.vue'
import Account from './Account.vue'
// import { useSidebarStore } from '@/stores/sidebar.js'

const headerClassNames = ref('p-0')
const { colorMode, setColorMode } = useColorModes('coreui-free-vue-admin-template-theme')
// const sidebar = useSidebarStore()

const $data = reactive({
  visible: false,
  modals: {
    login: false,
    signup: false
  }
});

onMounted(() => {
  document.addEventListener('scroll', () => {
    if (document.documentElement.scrollTop > 0) {
      headerClassNames.value = 'mb-4 p-0 shadow-sm'
    } else {
      headerClassNames.value = 'mb-4 p-0'
    }
  })
})
</script>
