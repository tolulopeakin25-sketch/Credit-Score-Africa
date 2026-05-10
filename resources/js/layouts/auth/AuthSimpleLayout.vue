<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Lock, Shield, TrendingUp } from 'lucide-vue-next';

defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <div class="min-h-screen" style="background-color: #edf1ee">
        <div class="relative flex min-h-screen flex-col items-center justify-center gap-6 p-6 md:p-10">
            <!-- Left side - Image preview (hidden on mobile) -->
            <div class="absolute inset-0 left-0 top-0 py-0 right-1/2 hidden overflow-hidden md:block">
                <img src="/images/loginImage.jpg" alt="Register page preview" class="h-full w-full object-cover" />
            </div>

            <!-- Right side - Form -->
            <div class="w-full max-w-sm md:ml-auto md:mr-20">
                <div class="flex flex-col gap-8">
                    <div class="flex items-center justify-center gap-2 md:justify-start">
                        <Link :href="route('home')" class="flex items-center gap-2 font-medium">
                            <img src="/images/logo.png" alt="CreditScore Africa" class="h-10 w-10 rounded-lg" />
                            <div class="text-lg font-bold">
                                <span style="color: #3c4355">CreditScore</span>
                                <span style="color: #f2405e"> Africa</span>
                            </div>
                        </Link>
                    </div>
                    <!-- Title & Description -->
                    <div class="space-y-2 text-center md:text-left">
                        <h1 class="text-2xl font-bold text-slate-900">{{ title }}</h1>
                        <p class="text-sm text-slate-600">{{ description }}</p>
                    </div>
                    <slot />
                </div>
            </div>
        </div>
    </div>
</template>
