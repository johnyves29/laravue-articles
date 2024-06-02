<template>
    <!--
    This example requires updating your template:

    ```
    <html class="h-full bg-gray-100">
    <body class="h-full">
    ```
  -->
    <div class="min-h-full">
        <Disclosure as="nav" class="bg-gray-800">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <img
                                class="h-8 w-8"
                                src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=500"
                                alt="Your Company"
                            />
                        </div>
                        <h1 class="m-3 text-white font-medium">
                            Laravel Vue Tailwind App
                        </h1>
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-4 flex items-center md:ml-6"></div>
                    </div>
                </div>
            </div>
        </Disclosure>
        <main>
            <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
                <!-- Your content -->
                <PostList />
            </div>
        </main>
    </div>
</template>

<script setup>
import PostList from '../components/PostList.vue'
import { Disclosure } from '@headlessui/vue'
</script>
