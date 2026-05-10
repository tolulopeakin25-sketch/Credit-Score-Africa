<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle, Lock, Mail, User } from 'lucide-vue-next';
import { computed, ref } from 'vue';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

const socialLoading = ref<'google' | 'apple' | null>(null);

const passwordStrength = computed(() => {
    if (!form.password) return { score: 0, label: '', color: '' };
    let score = 0;
    if (form.password.length >= 8) score++;
    if (/[a-z]/.test(form.password) && /[A-Z]/.test(form.password)) score++;
    if (/\d/.test(form.password)) score++;
    if (/[^a-zA-Z\d]/.test(form.password)) score++;

    return {
        score,
        label: score === 0 ? 'Too weak' : score === 1 ? 'Weak' : score === 2 ? 'Fair' : score === 3 ? 'Good' : 'Strong',
        color: score === 0 || score === 1 ? 'bg-red-500' : score === 2 ? 'bg-yellow-500' : score === 3 ? 'bg-blue-500' : 'bg-green-500',
    };
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
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
    <AuthBase title="Build Your Credit Profile" description="Join thousands of Africans building stronger credit scores">
        <Head title="Register" />

        <form @submit.prevent="submit" class="flex flex-col gap-4 sm:gap-6">
            <div class="grid gap-4 sm:gap-5">
                <div class="grid gap-2">
                    <Label for="name" class="text-sm sm:text-base font-medium text-slate-900">Full Name</Label>
                    <div class="relative">
                        <User class="absolute left-3 top-1/2 h-4 w-4 sm:h-5 sm:w-5 -translate-y-1/2 transform text-slate-500" />
                        <Input
                            id="name"
                            type="text"
                            required
                            autofocus
                            tabindex="1"
                            autocomplete="name"
                            v-model="form.name"
                            placeholder="Your full name"
                            class="border-slate-300 bg-white pl-10 text-sm sm:text-base text-slate-900 placeholder-slate-500 focus:border-blue-500 focus:ring-blue-500"
                        />
                    </div>
                    <InputError :message="form.errors.name" />
                </div>

                <div class="grid gap-2">
                    <Label for="email" class="text-sm sm:text-base font-medium text-slate-900">Email Address</Label>
                    <div class="relative">
                        <Mail class="absolute left-3 top-1/2 h-4 w-4 sm:h-5 sm:w-5 -translate-y-1/2 transform text-slate-500" />
                        <Input
                            id="email"
                            type="email"
                            required
                            tabindex="2"
                            autocomplete="email"
                            v-model="form.email"
                            placeholder="you@example.com"
                            class="border-slate-300 bg-white pl-10 text-sm sm:text-base text-slate-900 placeholder-slate-500 focus:border-blue-500 focus:ring-blue-500"
                        />
                    </div>
                    <InputError :message="form.errors.email" />
                </div>

                <div class="grid gap-2">
                    <Label for="password" class="font-medium text-slate-900">Password</Label>
                    <div class="relative">
                        <Lock class="absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 transform text-slate-500" />
                        <Input
                            id="password"
                            type="password"
                            required
                            tabindex="3"
                            autocomplete="new-password"
                            v-model="form.password"
                            placeholder="••••••••"
                            class="border-slate-300 bg-white pl-10 text-slate-900 placeholder-slate-500 focus:border-blue-500 focus:ring-blue-500"
                        />
                    </div>
                    <div v-if="form.password" class="mt-2 flex items-center gap-2">
                        <div class="h-1.5 flex-1 rounded-full bg-slate-300">
                            <div
                                :class="`h-1.5 rounded-full transition-all ${passwordStrength.color}`"
                                :style="{ width: `${(passwordStrength.score / 4) * 100}%` }"
                            ></div>
                        </div>
                        <span class="text-xs text-slate-600">{{ passwordStrength.label }}</span>
                    </div>
                    <p class="mt-1 text-xs text-slate-600">Min. 8 characters, mix of uppercase, lowercase, numbers & symbols</p>
                    <InputError :message="form.errors.password" />
                </div>

                <div class="grid gap-2">
                    <Label for="password_confirmation" class="text-sm sm:text-base font-medium text-slate-900">Confirm Password</Label>
                    <div class="relative">
                        <Lock class="absolute left-3 top-1/2 h-4 w-4 sm:h-5 sm:w-5 -translate-y-1/2 transform text-slate-500" />
                        <Input
                            id="password_confirmation"
                            type="password"
                            required
                            tabindex="4"
                            autocomplete="new-password"
                            v-model="form.password_confirmation"
                            placeholder="••••••••"
                            class="border-slate-300 bg-white pl-10 text-sm sm:text-base text-slate-900 placeholder-slate-500 focus:border-blue-500 focus:ring-blue-500"
                        />
                    </div>
                    <InputError :message="form.errors.password_confirmation" />
                </div>

                <!-- Divider -->
                <div class="relative py-2 sm:py-3">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-slate-300"></div>
                    </div>
                    <div class="relative flex justify-center text-xs sm:text-sm">
                        <span class="px-2 text-slate-500" style="background-color: #edf1ee">or</span>
                    </div>
                </div>

                <!-- Social Sign Up Section -->
                <!-- <div class="grid grid-cols-2 gap-2 sm:gap-3"> -->
                    <!-- <Button
                        type="button"
                        @click="handleSocialLogin('google')"
                        :disabled="socialLoading !== null"
                        variant="outline"
                        class="h-auto border-slate-300 bg-white py-2 sm:py-2.5 px-3 sm:px-4 font-medium text-xs sm:text-sm text-slate-900 hover:bg-slate-50 hover:text-slate-700 disabled:opacity-50"
                    >
                        <img src="/images/google.png" alt="Google" class="mr-1 sm:mr-2 h-4 w-4 sm:h-5 sm:w-5" />
                        <span v-if="socialLoading !== 'google'">Google</span>
                        <LoaderCircle v-else class="h-4 w-4 animate-spin" />
                    </Button> -->

                    <!-- <Button
                        type="button"
                        @click="handleSocialLogin('apple')"
                        :disabled="socialLoading !== null"
                        variant="outline"
                        class="h-auto border-slate-300 bg-white py-2 sm:py-2.5 px-3 sm:px-4 font-medium text-xs sm:text-sm text-slate-900 hover:bg-slate-50 hover:text-black-700 disabled:opacity-50"
                    />
                        <img src="/images/apple-logo.png" alt="Apple" class="mr-1 sm:mr-2 h-4 w-4 sm:h-5 sm:w-5" />
                        <span v-if="socialLoading !== 'apple'">Apple</span>
                        <LoaderCircle v-else class="h-4 w-4 animate-spin" /> -->
                        <!-- or :message="form.errors.password_confirmation" /> -->
                <!-- </div> -->

                <!-- Divider -->
                <!-- <div class="relative py-2 sm:py-3">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-slate-300"></div>
                    </div>
                    <div class="relative flex justify-center text-xs sm:text-sm">
                        <span class="px-2 text-slate-500" style="background-color: #edf1ee">or</span>
                    </div>
                </div> -->

                <!-- Social Sign Up Section -->
                <div class="grid grid-cols-2 gap-2 sm:gap-3">
                    <Button
                        type="button"
                        variant="outline"
                        class="h-auto border-slate-300 bg-white py-2 sm:py-2.5 px-3 sm:px-4 font-medium text-xs sm:text-sm text-slate-900 hover:bg-slate-50 hover:text-slate-700"
                    >
                        <img src="/images/google.png" alt="Google" class="mr-1 sm:mr-2 h-4 w-4 sm:h-5 sm:w-5" />
                        Google
                    </Button>

                    <Button
                        type="button"
                        variant="outline"
                        class="h-auto border-slate-300 bg-white py-2 sm:py-2.5 px-3 sm:px-4 font-medium text-xs sm:text-sm text-slate-900 hover:bg-slate-50 hover:text-black-700"
                    >
                        <img src="/images/apple-logo.png" alt="Apple" class="mr-1 sm:mr-2 h-4 w-4 sm:h-5 sm:w-5" />
                        Apple
                    </Button>
                </div>

                <div class="flex items-start gap-2 sm:gap-3 pt-2">
                    <Checkbox id="terms" v-model:checked="form.terms" tabindex="5" class="mt-1 border-slate-300" />
                    <Label for="terms" class="cursor-pointer text-xs sm:text-sm font-normal text-slate-700">
                        I agree to the
                        <TextLink href="#" class="text-blue-700 dark:text-blue-700 no-underline" style="text-decoration: none;">Terms of Service</TextLink>
                        and
                        <TextLink href="#" class="text-blue-700 dark:text-blue-700 no-underline" style="text-decoration: none;">Privacy Policy</TextLink>
                    </Label>
                </div>

                <Button
                    type="submit"
                    class="mt-2 sm:mt-4 h-auto w-full rounded-lg bg-gradient-to-r from-blue-600 to-blue-700 py-2.5 sm:py-3 px-4 font-semibold text-sm sm:text-base text-white transition-all duration-200 hover:from-blue-700 hover:to-blue-800 active:scale-95"
                    tabindex="6"
                    :disabled="form.processing || !form.terms"
                >
                    <LoaderCircle v-if="form.processing" class="mr-2 h-4 w-4 animate-spin" />
                    {{ form.processing ? 'Creating Account...' : 'Create Account' }}
                </Button>
            </div>

            <div class="text-center text-xs sm:text-sm text-slate-600">
                Already have an account?
                <TextLink :href="route('login')" class="font-semibold text-blue-700 dark:text-blue-700 transition-colors hover:text-blue-900"> Log in here </TextLink>
            </div>
        </form>
    </AuthBase>
</template>
