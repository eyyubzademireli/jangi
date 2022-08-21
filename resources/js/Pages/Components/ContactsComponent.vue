<template>
    <div class="w-full 2xl:h-[45rem] bg-transparent xl:min-h-[46rem] lg:min-h-[40rem] md:min-h-[36rem] sm:min-h-[32rem] overflow-hidden flex flex-col justify-start items-center select-none 2xl:px-16 2xl:py-4 xl:px-16 xl:py-4 lg:px-10 lg:py-4 md:px-6 md:py-2 sm:px-4 sm:py-2">

        <div @click="hideToast" v-if="toast" class="w-full h-full fixed top-0 left-0 z-50 flex justify-center items-center">
            <div class="fixed top-0 left-0 w-full h-full z-0 bg-gray-900 opacity-30"></div>
            <div class="max-w-96 px-20 py-10 rounded bg-white shadow-md z-10 flex justify-center items-center text-center text-gray-900 text-xl"><span>{{ toastMessage }}</span></div>
        </div>

        <!-- Head text starts -->
            <div class="w-full flex justify-center items-center text-gray-900 font-[900] mt-10 2xl:text-4xl">
                <span>BİZİMLƏ ƏLAQƏ</span>
            </div>
        <!-- Head text ends -->

        <div class="2xl:w-[72rem] flex justify-center items-start mt-10 space-x-4 space-y-4">
            <div class="w-[40%] flex flex-col space-y-4 pt-[1.2rem]">
                <div class="flex flex-col space-y-1">
                    <div class="w-full flex space-x-4 items-center">
                        <i class="fa-solid fa-location-dot text-red-500"></i>
                        <span class="text-xl font-[600]">ÜNVAN</span>
                    </div>
                    <div class="w-full">
                        <span>{{info.address}}</span>
                    </div>
                </div>

                <div class="flex flex-col space-y-1">
                    <div class="w-full flex space-x-4 items-center">
                        <i class="fa-solid fa-phone text-red-500"></i>
                        <span class="text-xl font-[600]">MOBİL TELEFON</span>
                    </div>
                    <div class="w-full">
                        <span>{{info.mobile}}</span>
                    </div>
                </div>

                <div class="flex flex-col space-y-1">
                    <div class="w-full flex space-x-4 items-center">
                        <i class="fa-solid fa-phone text-red-500"></i>
                        <span class="text-xl font-[600]">ŞƏHƏR TELEFONU</span>
                    </div>
                    <div class="w-full">
                        <span>{{info.phone}}</span>
                    </div>
                </div>

                <div class="flex flex-col space-y-1">
                    <div class="w-full flex space-x-4 items-center">
                        <i class="fa-brands fa-whatsapp-square text-red-500"></i>
                        <span class="text-xl font-[600]">WHATSAPP</span>
                    </div>
                    <div class="w-full">
                        <span>{{info.whatsapp}}</span>
                    </div>
                </div>

                <div class="flex space-x-4 items-center text-xl">
                    <a :href="info.facebook" target="_blank"><i class="fa-brands fa-facebook-square text-red-500"></i></a>
                    <a :href="info.instagram" target="_blank"><i class="fa-brands fa-instagram-square text-red-500"></i></a>
                    <a :href="info.youtube" target="_blank"><i class="fa-brands fa-youtube text-red-500"></i></a>
                    <a :href="'mailto:'+info.email" target="_blank"><i class="fa-solid fa-envelope text-red-500"></i></a>
                </div>
            </div>

            <div class="w-[42%] flex flex-col space-y-2">
                <div class="w-full flex space-x-4 justify-start items-start">
                    <div class="w-full flex flex-col space-y-2">
                        <span class="text-gray-900 text-base font-[600]">Adınız:</span>
                        <input v-model.trim="name" class="border-gray-400 placeholder:text-gray-600" type="text" placeholder="Adınız">
                    </div>
                    <div class="w-full flex flex-col space-y-2">
                        <span class="text-gray-900 text-base font-[600]">Soyadınız:</span>
                        <input v-model.trim="surname" class="border-gray-400 placeholder:text-gray-600" type="text" placeholder="Soyadınız">
                    </div>
                </div>
                <div class="w-full flex flex-col space-y-2">
                    <span class="text-gray-900 text-base font-[600]">Emailiniz:</span>
                    <input v-model.trim="email" class="border-gray-400 placeholder:text-gray-600" type="email" placeholder="Emailiniz">
                </div>
                <div class="w-full flex flex-col space-y-2">
                    <span class="text-gray-900 text-base font-[600]">İsmarıcınız:</span>
                    <textarea v-model.trim="message" class="border-gray-400 placeholder:text-gray-600 resize-none h-44" maxlength="400" placeholder="İsmarıcınız"></textarea>
                </div>
                <div class="w-full space-y-2">
                    <div @click="send" class="w-full flex justify-center items-center py-2 text-xl text-white font-[600] bg-gray-900 cursor-pointer hover:bg-gray-800"><span>GÖNDƏR</span></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { defineComponent, ref } from 'vue';

export default defineComponent ({
    name: "ContactsComponent",
    props: [
        'info'
    ],
    setup(props) {
        // Properties
        const info = props.info;
        const name = ref('');
        const surname = ref('');
        const email = ref('');
        const message = ref('');
        const toast = ref(false);
        const toastMessage = ref('');


        // Methods
        const send = () => {
            if(name.value == '' || surname.value == '' || email.value == '' || message.value == '') {
                toastMessage.value = 'Zəhmət olmasa bütün sahələri doldurun!';
                toast.value = true;

                setTimeout(() => {
                    hideToast();
                }, 1500);
                return;
            }
            axios.post('/send', {
                name: name.value,
                surname: surname.value,
                email: email.value,
                message: message.value
            }).then(response => {
                if (response.data.success == true) {
                    toastMessage.value = 'Mesajınız uğurla göndərildi';
                    toast.value = true;
                    name.value = '';
                    surname.value = '';
                    email.value = '';
                    message.value = '';
                }else {
                    toastMessage.value = 'Mesajınız göndərilərkən xəta baş verdi.';
                    toast.value = true;
                }
                setTimeout(() => {
                    hideToast();
                }, 1500);
            }).catch(() => {
                toastMessage.value = 'Mesajınız göndərilərkən xəta baş verdi.';
                toast.value = true;
                setTimeout(() => {
                    hideToast();
                }, 2000);
            });
        };

        const hideToast = () => {
            toast.value = false;
            toastMessage.value = '';
        };

        // Computeds

        return {
            // Properties
            name,
            surname,
            email,
            message,
            info,
            toast,
            toastMessage,

            // Methods
            send,
            hideToast

        }
    }
})
</script>
