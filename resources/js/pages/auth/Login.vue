<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle, Lock, Mail } from 'lucide-vue-next';
import { ref } from 'vue';

defineProps<{
    status?: string;
    canResetPassword: boolean;
}>();

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const socialLoading = ref<'google' | 'apple' | null>(null);

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};

const handleSocialLogin = (provider: 'google' | 'apple') => {
    socialLoading.value = provider;
    
    const width = 500;
    const height = 600;
    const left = window.screenX + (window.outerWidth - width) / 2;
    const top = window.screenY + (window.outerHeight - height) / 2;
    
    const popup = window.open(
        route(`auth.${provider}`),
        `${provider}-login`,
        `width=${width},height=${height},left=${left},top=${top},resizable=yes,scrollbars=yes`
    );

    if (popup) {
        const checkPopup = setInterval(() => {
            try {
                if (popup.closed) {
                    clearInterval(checkPopup);
                    socialLoading.value = null;
                    // Refresh the page to check if user is authenticated
                    window.location.reload();
                }
            } catch (e) {
                // Handle cross-origin issues
            }
        }, 1000);
    }
};
</script>

<template>
    <AuthBase title="Welcome Back" description="Structured insights. Secure access. Full consent.">
        <Head title="Log in" />

        <div v-if="status" class="mb-4 rounded-lg border border-green-200 bg-green-50 p-3 text-center text-sm font-medium text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit" class="flex flex-col gap-6">
            <div class="grid gap-5">
                <div class="grid gap-2">
                    <Label for="email" class="font-medium text-slate-900">Email Address</Label>
                    <div class="relative">
                        <Mail class="absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 transform text-slate-500" />
                        <Input
                            id="email"
                            type="email"
                            required
                            autofocus
                            tabindex="1"
                            autocomplete="email"
                            v-model="form.email"
                            placeholder="you@example.com"
                            class="border-slate-300 bg-white pl-10 text-slate-900 placeholder-slate-500 focus:border-blue-500 focus:ring-blue-500"
                        />
                    </div>
                    <InputError :message="form.errors.email" />
                </div>

                <div class="grid gap-2">
                    <div class="flex items-center justify-between">
                        <Label for="password" class="font-medium text-slate-900">Password</Label>
                        <TextLink
                            v-if="canResetPassword"
                            :href="route('password.request')"
                            class="text-xs text-blue-600 dark:text-blue-600 transition-colors hover:text-blue-700"
                        >
                            Forgot password?
                        </TextLink>
                    </div>
                    <div class="relative">
                        <Lock class="absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 transform text-slate-500" />
                        <Input
                            id="password"
                            type="password"
                            required
                            tabindex="2"
                            autocomplete="current-password"
                            v-model="form.password"
                            placeholder="••••••••"
                            class="border-slate-300 bg-white pl-10 text-slate-900 placeholder-slate-500 focus:border-blue-500 focus:ring-blue-500"
                        />
                    </div>
                    <InputError :message="form.errors.password" />
                </div>

                <div class="flex items-center justify-between pt-2">
                    <Label for="remember" class="flex cursor-pointer items-center gap-3">
                        <Checkbox id="remember" v-model:checked="form.remember" tabindex="3" class="border-slate-300" />
                        <span class="text-sm text-slate-600">Remember me for 30 days</span>
                    </Label>
                </div>

                <Button
                    type="submit"
                    class="mt-4 h-auto w-full rounded-lg bg-gradient-to-r from-blue-600 to-blue-700 py-2.5 font-semibold text-white transition-all duration-200 hover:from-blue-700 hover:to-blue-800"
                    tabindex="4"
                    :disabled="form.processing"
                >
                    <LoaderCircle v-if="form.processing" class="mr-2 h-4 w-4 animate-spin" />
                    {{ form.processing ? 'Logging in...' : 'Log In' }}
                </Button>
            </div>

            <div class="relative py-4">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-slate-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="bg-white px-2 text-slate-500" style="background-color: #edf1ee">or continue with</span>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <Button
                    type="button"
                    @click="handleSocialLogin('google')"
                    :disabled="socialLoading !== null"
                    class="flex h-10 items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white text-slate-700 transition-all duration-200 hover:bg-slate-50 disabled:opacity-50"
                >
                    <img src="/images/google.png" alt="Google" class="h-5 w-5" />
                    <span v-if="socialLoading !== 'google'" class="text-sm font-medium">Google</span>
                    <LoaderCircle v-else class="h-4 w-4 animate-spin" />
                </Button>

                <Button
                    type="button"
                    @click="handleSocialLogin('apple')"
                    :disabled="socialLoading !== null"
                    class="flex h-10 items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white text-slate-700 transition-all duration-200 hover:bg-slate-50 disabled:opacity-50"
                >
                    <img src="/images/apple-logo.png" alt="Apple" class="h-5 w-5" />
                    <span v-if="socialLoading !== 'apple'" class="text-sm font-medium">Apple</span>
                    <LoaderCircle v-else class="h-4 w-4 animate-spin" />
                </Button>
            </div>

            <div class="text-center text-sm text-slate-600">
                Don't have an account?
                <TextLink :href="route('register')" class="font-semibold text-blue-700 dark:text-blue-700 transition-colors hover:text-blue-700">
                    Create one now
                </TextLink>
            </div>

            <div class="mt-4 flex items-center justify-center gap-1 border-t border-slate-300 pt-4 text-xs text-slate-500">
                <Lock class="h-3 w-3" />
                <span>Your data is encrypted and secure</span>
            </div>
        </form>
    </AuthBase>
</template>
