<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Link, useForm } from '@inertiajs/inertia-vue3';
import JetButton from '@/Jetstream/Button.vue';
import JetFormSection from '@/Jetstream/FormSection.vue';
import JetInput from '@/Jetstream/Input.vue';
import JetInputError from '@/Jetstream/InputError.vue';
import JetLabel from '@/Jetstream/Label.vue';
import JetActionMessage from '@/Jetstream/ActionMessage.vue';
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue';

const props = defineProps({
    info: Object,
});

const form = useForm({
    _method: 'PUT',
    address: props.info.address,
    mobile: props.info.mobile,
    phone: props.info.phone,
    whatsapp: props.info.whatsapp,
    facebook: props.info.facebook,
    instagram: props.info.instagram,
    youtube: props.info.youtube,
    email: props.info.email,
});

const updateInformations = () => {
    form.post(route('update-information'), {
        errorBag: 'updateInformations',
        preserveScroll: true,
    });
};

</script>

<template>
    <JetFormSection @submitted="updateInformations">
        <template #title>
            Əlaqə məlumatları
        </template>

        <template #description>
            Saytdakı əlaqə məlumatlarını buradan dəyişin.
        </template>

        <template #form>
            <!-- address -->
            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="address" value="Ünvan" />
                <JetInput
                    id="address"
                    v-model="form.address"
                    type="text"
                    class="mt-1 block w-full"
                    autocomplete="address"
                />
                <JetInputError :message="form.errors.address" class="mt-2" />
            </div>

            <!-- mobile -->
            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="mobile" value="Mobil" />
                <JetInput
                    id="mobile"
                    v-model="form.mobile"
                    type="text"
                    class="mt-1 block w-full"
                    autocomplete="mobile"
                />
                <JetInputError :message="form.errors.mobile" class="mt-2" />
            </div>

            <!-- phone -->
            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="phone" value="Şəhər telefonu" />
                <JetInput
                    id="phone"
                    v-model="form.phone"
                    type="text"
                    class="mt-1 block w-full"
                    autocomplete="phone"
                />
                <JetInputError :message="form.errors.phone" class="mt-2" />
            </div>

            <!-- whatsapp -->
            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="whatsapp" value="Whatsapp" />
                <JetInput
                    id="whatsapp"
                    v-model="form.whatsapp"
                    type="text"
                    class="mt-1 block w-full"
                    autocomplete="whatsapp"
                />
                <JetInputError :message="form.errors.whatsapp" class="mt-2" />
            </div>

            <!-- facebook -->
            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="facebook" value="Facebook" />
                <JetInput
                    id="facebook"
                    v-model="form.facebook"
                    type="text"
                    class="mt-1 block w-full"
                    autocomplete="facebook"
                />
                <JetInputError :message="form.errors.facebook" class="mt-2" />
            </div>

            <!-- instagram -->
            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="instagram" value="Instagram" />
                <JetInput
                    id="instagram"
                    v-model="form.instagram"
                    type="text"
                    class="mt-1 block w-full"
                    autocomplete="instagram"
                />
                <JetInputError :message="form.errors.instagram" class="mt-2" />
            </div>

            <!-- youtube -->
            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="youtube" value="Youtube" />
                <JetInput
                    id="youtube"
                    v-model="form.youtube"
                    type="text"
                    class="mt-1 block w-full"
                    autocomplete="youtube"
                />
                <JetInputError :message="form.errors.youtube" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="email" value="Email" />
                <JetInput
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="mt-1 block w-full"
                />
                <JetInputError :message="form.errors.email" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <JetActionMessage :on="form.recentlySuccessful" class="mr-3">
                Yadda saxlanıldı.
            </JetActionMessage>

            <JetButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Yadda saxla
            </JetButton>
        </template>
    </JetFormSection>
</template>
