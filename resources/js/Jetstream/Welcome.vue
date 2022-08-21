<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import JetSectionBorder from '@/Jetstream/SectionBorder.vue';
import LogoutOtherBrowserSessionsForm from '@/Pages/Profile/Partials/InfoForm.vue';

defineProps({
    confirmsTwoFactorAuthentication: Boolean,
    sessions: Array,
});
</script>

<template>
    <AppLayout title="Məlumatlar">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Məlumatlar
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div>
                    <InfoForm :info="$page.props.info" />

                    <JetSectionBorder />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
