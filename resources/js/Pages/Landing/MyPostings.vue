<template>
    <LandingLayout>
        <Head title="My Postings" />
        <div class="container pt-26">
            <div class="row">
                <div class="col-12">
                    <div class="mb-18">
                        <div class="row mb-6 align-items-center">
                            <div class="col-lg-6 mb-lg-0 mb-4">
                                <h3 class="font-size-6 mb-0">Posted Adverts</h3>
                            </div>
                            <div class="col-lg-6">
                                <div class="d-flex flex-wrap align-items-center justify-content-lg-end">
                                    <p class="font-size-4 mb-0 mr-6 py-2">Filter by category:</p>
                                    <div class="h-px-48">
                                    <select name="country" id="country" class="nice-select pl-7 h-100 arrow-3 arrow-3-black min-width-px-273 font-weight-semibold text-black-2">
                                        <option value="" data-display="Product Designer">Full-Time</option>
                                    </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white shadow-8 pt-7 rounded pb-9 px-11">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="pl-0 border-0 font-size-4 font-weight-normal">Name</th>
                                            <th scope="col" class="pl-4 border-0 font-size-4 font-weight-normal">Job Type</th>
                                            <th scope="col" class="pl-4 border-0 font-size-4 font-weight-normal">City</th>
                                            <th scope="col" class="pl-4 border-0 font-size-4 font-weight-normal">Created on</th>
                                            <th scope="col" class="pl-4 border-0 font-size-4 font-weight-normal">Total Applicants</th>
                                            <th scope="col" class="pl-4 border-0 font-size-4 font-weight-normal"></th>
                                            <th scope="col" class="pl-4 border-0 font-size-4 font-weight-normal"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="border border-color-2">
                                            <th scope="row" class="pl-6 border-0 py-7 min-width-px-235">
                                            <div class="">
                                                <a href="jobdetails.html" class="font-size-4 mb-0 font-weight-semibold text-black-2">Senior Project Manager</a>
                                            </div>
                                            </th>
                                            <td class="table-y-middle py-7 min-width-px-135">
                                            <h3 class="font-size-4 font-weight-normal text-black-2 mb-0">Full-Time</h3>
                                            </td>
                                            <td class="table-y-middle py-7 min-width-px-125">
                                            <h3 class="font-size-4 font-weight-normal text-black-2 mb-0">New York</h3>
                                            </td>
                                            <td class="table-y-middle py-7 min-width-px-155">
                                            <h3 class="font-size-4 font-weight-normal text-black-2 mb-0">12 July, 2020</h3>
                                            </td>
                                            <td class="table-y-middle py-7 min-width-px-205">
                                            <h3 class="font-size-4 font-weight-bold text-black-2 mb-0">47</h3>
                                            </td>
                                            <td class="table-y-middle py-7 min-width-px-80">
                                            <a href="" class="font-size-3 font-weight-bold text-green text-uppercase">Edit</a>
                                            </td>
                                            <td class="table-y-middle py-7 min-width-px-100">
                                            <a href="" class="font-size-3 font-weight-bold text-red-2 text-uppercase">Delete</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="pt-2">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination pagination-hover-primary rounded-0 ml-n2">
                                    <li class="page-item rounded-0 flex-all-center">
                                        <a class="page-link rounded-0 border-0 px-3active" href="#" aria-label="Previous">
                                        <i class="fas fa-chevron-left"></i>
                                        </a>
                                    </li>
                                    <li class="page-item"><a class="page-link border-0 font-size-4 font-weight-semibold px-3" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link border-0 font-size-4 font-weight-semibold px-3" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link border-0 font-size-4 font-weight-semibold px-3" href="#">3</a></li>
                                    <li class="page-item disabled"><a class="page-link border-0 font-size-4 font-weight-semibold px-3" href="#">...</a></li>
                                    <li class="page-item "><a class="page-link border-0 font-size-4 font-weight-semibold px-3" href="#">7</a></li>
                                    <li class="page-item rounded-0 flex-all-center">
                                        <a class="page-link rounded-0 border-0 px-3" href="#" aria-label="Next">
                                        <i class="fas fa-chevron-right"></i>
                                        </a>
                                    </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>        
    </LandingLayout>    
</template>
<script lang="ts" setup>
import { LandingLayout } from '@/Layouts'
import { Head } from '@inertiajs/vue3';
</script>