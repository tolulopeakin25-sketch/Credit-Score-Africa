<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { TrendingUp, Shield, CreditCard, Target } from 'lucide-vue-next';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

defineProps<{
    name?: string;
}>();
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 rounded-xl p-6" style="background-color: #edf1ee">
            <!-- Welcome Header -->
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-slate-900">
                    Welcome back, {{ name || 'User' }}!
                </h1>
                <p class="mt-2 text-slate-600">
                    Here's your credit score overview and latest insights.
                </p>
            </div>

            <!-- Stats Cards -->
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-gradient-to-br from-blue-500 to-blue-600">
                            <CreditCard class="h-6 w-6 text-white" />
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-600">Credit Score</p>
                            <p class="text-2xl font-bold text-slate-900">742</p>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center gap-2">
                        <TrendingUp class="h-4 w-4 text-green-500" />
                        <span class="text-sm text-green-600">+12 this month</span>
                    </div>
                </div>

                <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-gradient-to-br from-green-500 to-green-600">
                            <Target class="h-6 w-6 text-white" />
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-600">Goal Progress</p>
                            <p class="text-2xl font-bold text-slate-900">78%</p>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center gap-2">
                        <span class="text-sm text-slate-500">Target: 800</span>
                    </div>
                </div>

                <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-gradient-to-br from-purple-500 to-purple-600">
                            <Shield class="h-6 w-6 text-white" />
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-600">Security Status</p>
                            <p class="text-lg font-bold text-green-600">Protected</p>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center gap-2">
                        <span class="text-sm text-slate-500">All accounts secured</span>
                    </div>
                </div>

                <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-gradient-to-br from-orange-500 to-orange-600">
                            <TrendingUp class="h-6 w-6 text-white" />
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-600">Monthly Change</p>
                            <p class="text-2xl font-bold text-slate-900">+8</p>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center gap-2">
                        <span class="text-sm text-green-600">Improving</span>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid gap-6 lg:grid-cols-3">
                <!-- Credit Score Chart -->
                <div class="lg:col-span-2 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="text-xl font-semibold text-slate-900 mb-4">Credit Score Trend</h3>
                    <div class="h-64 flex items-center justify-center rounded-lg border-2 border-dashed border-slate-300">
                        <div class="text-center">
                            <TrendingUp class="mx-auto h-12 w-12 text-slate-400 mb-2" />
                            <p class="text-slate-500">Chart visualization would go here</p>
                            <p class="text-sm text-slate-400">Score trending upward over time</p>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="text-xl font-semibold text-slate-900 mb-4">Recent Activity</h3>
                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-100">
                                <CreditCard class="h-4 w-4 text-blue-600" />
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-slate-900">Credit inquiry</p>
                                <p class="text-xs text-slate-500">2 days ago</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-green-100">
                                <Target class="h-4 w-4 text-green-600" />
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-slate-900">Score improved</p>
                                <p class="text-xs text-slate-500">1 week ago</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-purple-100">
                                <Shield class="h-4 w-4 text-purple-600" />
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-slate-900">Account verified</p>
                                <p class="text-xs text-slate-500">2 weeks ago</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Brand Footer -->
            <div class="mt-8 text-center">
                <div class="inline-flex items-center gap-2">
                    <span class="text-lg font-bold" style="color: #3c4355">CreditScore</span>
                    <span class="text-lg font-bold" style="color: #f2405e">Africa</span>
                </div>
                <p class="mt-2 text-sm text-slate-500">Building stronger credit scores across Africa</p>
            </div>
        </div>
    </AppLayout>
</template>
