<template>
    <LandingLayout>
        <Head title="Profile" />
        <div class="container pt-26 pb-15">
            <div class="row">
                <div class="col-12">
                    <h4 class="font-size-6 font-weight-semibold mb-6">Profile</h4>
                    <div class="contact-form bg-white shadow-8 rounded-4 pl-sm-10 pl-4 pr-sm-11 pr-4 pt-15 pb-13">
                    <div class="upload-file mb-16 text-center">
                        <div id="userActions" class="square-144 m-auto px-6 mb-7">
                            <label for="fileUpload" class="mb-0 font-size-4 text-smoke">
                                Browse or Drag and Drop
                            </label>
                            <input type="file" id="fileUpload" class="sr-only" />
                        </div>
                        <!-- <img id="imgPrime" src="" alt="uploaded image placeholder" /> -->
                        <!-- <input type="file" id="upfile"> -->
                    </div>
                    <form action="/">
                        <fieldset>
                        <div class="row mb-xl-1 mb-9">
                            <div class="col-lg-6">
                            <div class="form-group">
                                <label for="namedash" class="d-block text-black-2 font-size-4 font-weight-semibold mb-4">Company Name</label>
                                <input type="text" class="form-control h-px-48" id="namedash" placeholder="eg. Apple">
                            </div>
                            </div>
                            <div class="col-lg-6">
                            <div class="form-group">
                                <label for="select2" class="d-block text-black-2 font-size-4 font-weight-semibold mb-4">Corporate Type</label>
                                <select id="select2" class="form-control nice-select pl-6 arrow-3 h-px-48 w-100 font-size-4">
                                <option>B2B</option>
                                <option>B3B</option>
                                <option>B4B</option>
                                <option>B5B</option>
                                </select>
                            </div>
                            </div>
                        </div>
                        <div class="row mb-8">
                            <div class="col-lg-6 mb-xl-0 mb-7">
                            <div class="form-group position-relative">
                                <label for="select3" class="d-block text-black-2 font-size-4 font-weight-semibold mb-4">Employee Size </label>
                                <select id="select3" class="form-control nice-select pl-6 arrow-3 h-px-48 w-100 font-size-4">
                                <option>10-50</option>
                                <option>50-70</option>
                                <option>70-80</option>
                                <option>80-90</option>
                                <option>90-100</option>
                                </select>
                            </div>
                            </div>
                            <div class="col-lg-6">
                            <div class="form-group position-relative">
                                <label for="address" class="d-block text-black-2 font-size-4 font-weight-semibold mb-4">Location or (Remote)</label>
                                <select name="address" id="address" class="nice-select pl-6 h-px-48 arrow-3 w-100 font-size-4">
                                <option value="">eg. New York, Namiv 201, USA</option>
                                <option value="">eg. New York, Namiv 202, USA</option>
                                <option value="">eg. New York, Namiv 203, USA</option>
                                <option value="">eg. New York, Namiv 204, USA</option>
                                <option value="">eg. New York, Namiv 205, USA</option>
                                </select>
                                <span class="h-100 w-px-50 pos-abs-tl d-flex align-items-center justify-content-center font-size-6"></span>
                            </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                            <div class="form-group">
                                <label for="aboutTextarea" class="d-block text-black-2 font-size-4 font-weight-semibold mb-4">About Comapny</label>
                                <textarea name="textarea" id="aboutTextarea" cols="30" rows="7" class="border border-mercury text-gray w-100 pt-4 pl-6" placeholder="Describe about the company what make it unique"></textarea>
                            </div>
                            </div>
                            <div class="col-md-12">
                            <div class="form-group mb-11">
                                <label for="formGroupExampleInput" class="d-block text-black-2 font-size-4 font-weight-semibold mb-4">Company Website Link</label>
                                <input type="text" class="form-control" id="formGroupExampleInput" placeholder="https://www.example.com">
                            </div>
                            <input type="button" value="Update Profile" class="btn btn-green btn-h-60 text-white min-width-px-210 rounded-5 text-uppercase">
                            </div>
                        </div>
                        </fieldset>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </LandingLayout>
</template>
<script lang="ts" setup>
import { LandingLayout } from '@/Layouts';
import { Head } from '@inertiajs/vue3';
</script>