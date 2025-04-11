<template>
    <CCol md="4" xs="12">
        <CCard class="mb-4">
            <CCardBody class="flex-column">
                <CCol md="12" class="d-flex justify-content-end">
                    <CDropdown>
                        <CDropdownToggle :caret="false" class="p-0"><CIcon name="cil-options"/></CDropdownToggle>
                        <CDropdownMenu>
                            <CDropdownItem :href="route('dashboard.postings.show', $props.data.id)">View</CDropdownItem>
                        </CDropdownMenu>
                    </CDropdown>
                </CCol>
                <CCol md="12" xs="12">
                    <CCol class="text-center">
                        <CAvatar color="primary" size="xl" class="text-white">{{ $props.data.title.charAt(0) }}</CAvatar>
                        <h4 class="my-2">{{ $props.data.title }}</h4>
                        <CListGroup>
                            <CListGroupItem>
                                {{ $props.data.category.name }},
                                {{ $props.data.sub_category.name }}
                            </CListGroupItem>
                            <CListGroupItem>{{ $props.data.user.name }}</CListGroupItem>
                            <CListGroupItem>{{ $props.data.created_at }}</CListGroupItem>
                        </CListGroup>
                    </CCol>
                </CCol>
            </CCardBody>
        </CCard>
    </CCol>    
</template>

<script lang="ts" setup>

// In your Vue component
const $props: any = defineProps({
    data: Object,
});
</script>